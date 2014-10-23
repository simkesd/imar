    // Area Chart
    $.ajax({
        type: "POST",
        url: apiUrl
    }).success(function( data ) {
        console.log(data);

        Morris.Line({
            element: 'sensor-chart',
            data: data,
            xkey: 'id',
            ykeys: ['value'],
            labels: ['id', 'value']
        });
    });
