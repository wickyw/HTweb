<?php
namespace Sessions;

class Model_Session extends \Orm\Model
{
	const DEADLINE_TIME = '16:00';
	const MAX_GUESTS = 20;
	
	const SETTLEABLE_AFTER = '5'; // Used to retrieve settleable sessions in days
	
	protected static $_properties = array(
		'id',
		'date' => array(
			'validation' => array('required', 'valid_date'),
		),
		'notes' => array(
			'default'     => ''
		), 
		'cost' => array(
			'default'     => 0.0
		), 
		'paid_by' => array(
			'default'     => 0
		), 
		'deadline',
		'settled' => array (
			'default' => false,
		),
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'sessions';	
	
	protected static $_has_many = array(
		'enrollments' => array(
			'model_to' => 'Sessions\Model_Enrollment_Session',
			'cascade_delete' => true,
		),
	);
	
	protected static $_has_one = array(
		'payer' => array(
			'key_from' => 'paid_by',
			'key_to' => 'id',
			'model_to' => '\Model_User',
			'cascade_delete' => false,
		)
	);
	
	/**
	 * Delete all (incomplete) session entries from database with no valid enrollments
	 */
	public static function scrub_empty_or_invalid() {
		$query = \DB::query('select s.id from sessions s, enrollment_sessions es where s.id = es.session_id group by s.id having sum(es.cook) = 0;')
				->execute()->as_array();

		$query2 = \DB::select('id')
				->from('sessions')
				->where('id', 'not in', \DB::query('select session_id from enrollment_sessions'))
				->execute()->as_array();
		
		// Prepare id array and delete
		$query = array_merge($query, $query2);
		foreach($query as $result) {
			Model_Session::find($result)->delete();
		}
	}
	
	/**
	 * Retrieve session from database by date
	 * @param string $date
	 * @return Model_Session
	 */
	public static function get_by_date($date) {
		return Model_Session::query()
				->where('date', $date)
				->get_one();
	}
	
	/**
	 * Retrieve sessions in which user is enrolled
	 * @param int $user_id
	 * @param boolean $include_self Include sessions in which user cooked
	 * @param boolean $settled Query settled session only
	 * @return /Sessions/Model_Session[]
	 */
	public static function get_by_user($user_id, $include_self=false, $settled=false) {
		$query = Model_Session::query()
			->related('enrollments')
			->where('enrollments.user_id', $user_id)
			->where('settled', $settled)
			->order_by('date', 'desc');
		
		if(!$include_self) {
			$query = $query->where('enrollments.cook', false);
		}
		
		return $query->get();
	}
	
	public static function get_by_cook($user_id, $settled=false) {
		return Model_Session::query()
			->related('enrollments')
			->where('enrollments.user_id', $user_id)
			->where('enrollments.cook', true)
			->where('settled', $settled)
			->order_by('date', 'desc')
			->get();
	}

	/**
	 * Retrieve all session older than 5 days that have not been settled yet
	 * @return \Sessions\Model_Session[]
	 */
	public static function get_ready_for_settlement() {
		return Model_Session::find('all', array(
			'where' => array(
				array(\DB::expr('DATE_ADD(date, INTERVAL ' . Model_Session::SETTLEABLE_AFTER . ' DAY)'), '<', date('Y-m-d')),
				array('settled', 0)
			)
		));
	}
	
	/* Below this line you will find instance methods */
		
	/**
	 * Retrieve a list of user receipts in this receipt sorted by name alphabetically
	 * @return \Sessions\Model_Enrollment_Session[]
	 */
	public function get_enrollments_sorted() {
		return Model_Enrollment_Session::query()
			->related('user')
			->order_by('user.name', 'asc')
			->where('session_id', $this->id)
			->get();
	}
	
	/**
	 * Determine if the given user is enrolled
	 * @param int $user_id
	 * @return boolean
	 */
	public function is_enrolled($user_id) {
		$user = \Auth::get_user($user_id);
		
		$enrollment = Model_Enrollment_Session::find('first', array(
					'where' => array(
						array('user_id', $user->id), array('session_id', $this->id))
				));

		return isset($enrollment);
	}	
	
	/**
	 * Retrieve the enrollment (if any) for the given user
	 * @param int $user_id
	 * @return \Sessions\Model_Enrollment_Session
	 */
	public function get_enrollment($user_id) {		
		$enrollment = Model_Enrollment_Session::find('first', array(
					'where' => array(
						array('user_id', $user_id), array('session_id', $this->id))
				));
		return $enrollment;
	}
	
	/**
	 * Retrieve the enrollment (if any) for the current user
	 * @return \Sessions\Model_Enrollment_Session
	 */
	public function current_enrollment() {
		return $this->get_enrollment(\Auth::get_user_id()[1]);
	}
	
	/**
	 * Get the number of cooks enrolled in this session
	 * @return int
	 */
	public function count_cooks() {
		return Model_Session::query()
				->where('id', $this->id)
				->related('enrollments')
				->where('enrollments.cook', true)
				->count('.user_id', true);
	}
	
	/**
	 * Get the number of dishwashers enrolled in this session
	 * @return int
	 */
	public function count_dishwashers() {
		return Model_Session::query()
				->related('enrollments')
				->where('id', $this->id)
				->where('enrollments.dishwasher', true)
				->count('.user_id', true);
	}
	
	/**
	 * Get the total amount of guests for this session
	 * @return int
	 */
	public function count_guests() {		
		$guest_count = array_values(\DB::select(\DB::expr('SUM(guests)'))
				->from('enrollment_sessions')
				->where('session_id', $this->id)
				->execute()[0])[0];
		
		if (empty($guest_count)) {
			return 0;
		}
		return $guest_count;
	}
	
	/**
	 * Get the amount of enrollments 
	 * including cooks and dishwashers, but excluding guests
	 * @return int
	 */
	public function count_participants() {
		return Model_Session::query()
				->related('enrollments')
				->where('id', $this->id)
				->count('.user_id', true);
	}
	
	/**
	 * Get the total amount of participants (all enrollments and their guests)
	 * @return int
	 */
	public function count_total_participants() {
		return $this->count_participants() + $this->count_guests();
	}
	
	/**
	 * Get the enrollments for all cooks enrolled in this session
	 * @return array \Sessions\Model_Enrollment_Session
	 */
	public function get_cook_enrollments() {
		$enrollments = Model_Enrollment_Session::find('all', array(
			'where' => array(
				array('cook', 1), array('session_id', $this->id)),
		));
		
		return $enrollments;
	}
	
	/**
	 * Get the enrollments for all cooks enrolled in this session
	 * @return array \Sessions\Model_Enrollment_Session
	 */
	public function get_dishwasher_enrollments() {
		$enrollments = Model_Enrollment_Session::find('all', array(
			'where' => array(
				array('dishwasher', 1), array('session_id', $this->id)),
		));
		
		return $enrollments;
	}
}
