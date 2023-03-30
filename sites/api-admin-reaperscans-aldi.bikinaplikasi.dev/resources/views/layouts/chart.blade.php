        var data = google.visualization.arrayToDataTable([
            ['Aplikasi Laundry', 'Total', { role: 'style' }],

            ['Rumah', {{ $rumahs->count() }}, '#aad360'],['Tentang', {{ $tentangs->count() }}, '#dac197'],['Disukai', {{ $disukai->count() }}, '#fff9d6'],['User', {{ $users->count() }}, '#aad380']
        ]);

        var options = {
          title : 'Aplikasi Laundry',
          vAxis: {title: 'Total'},
          hAxis: {title: ''},
          seriesType: 'bars',
          series: {6: {type: 'line'}}
        };