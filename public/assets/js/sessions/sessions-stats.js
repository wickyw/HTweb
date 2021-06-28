/**
 * Scripts for statistics bar chart
 * @author Melcher
 */

$('document').ready(function () {
    // Create a Bar Chart with Morris
    var chart = Morris.Bar({
        element: 'distr-bar-chart', // ID of the element in which to draw the chart.
        data: [0, 0], // Set initial data
        xkey: 'name', // Set the key for X-axis
        ykeys: ['points'], // Set the key for Y-axis
        labels: ['Points'] // Set the label when bar is rolled over
    });

    // Fire off an AJAX request to load the data
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "/sessions/stats/api", // This is the URL to the API
    })
        .done(function (data) {
            // When the response to the AJAX request comes back render the chart with new and sorted data
            sortByProperty(data, 'points',false);
            chart.setData(data);
        });
});

function sortByProperty(data, property, ascending=true) {
    data.sort(function (a, b) {
        if (ascending) {
            return (a[property] > b[property]) ? 1 : ((a[property] < b[property]) ? -1 : 0);
        } else {
            return (b[property] > a[property]) ? 1 : ((b[property] < a[property]) ? -1 : 0);
        }
    })
}

