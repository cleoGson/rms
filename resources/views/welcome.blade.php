<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script src="https://code.highcharts.com/gantt/highcharts-gantt.js"></script>
         <script src="https://code.highcharts.com/gantt/modules/exporting.js"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="/css/app.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div> 
                <div id="container"></div>
            </div>
        </div>
        <script src="js/app.js"></script>   
        <script>
        var today = new Date(),
  day = 1000 * 60 * 60 * 24,
  // Utility functions
  dateFormat = Highcharts.dateFormat,
  defined = Highcharts.defined,
  isObject = Highcharts.isObject,
  reduce = Highcharts.reduce;

// Set to 00:00:00:000 today
today.setUTCHours(0);
today.setUTCMinutes(0);
today.setUTCSeconds(0);
today.setUTCMilliseconds(0);
today = today.getTime();

Highcharts.ganttChart('container', {
  series: [{
    name: 'Offices',
    data: [{
      name: 'New offices',
      id: 'new_offices',
      owner: 'Peter'
    }, {
      name: 'Prepare office building',
      id: 'prepare_building',
      parent: 'new_offices',
      start: today - (2 * day),
      end: today + (6 * day),
      completed: {
        amount: 0.2
      },
      owner: 'Linda'
    }, {
      name: 'Inspect building',
      id: 'inspect_building',
      dependency: 'prepare_building',
      parent: 'new_offices',
      start: today + 6 * day,
      end: today + 8 * day,
      owner: 'Ivy'
    }, {
      name: 'Passed inspection',
      id: 'passed_inspection',
      dependency: 'inspect_building',
      parent: 'new_offices',
      start: today + 9.5 * day,
      milestone: true,
      owner: 'Peter'
    }, {
      name: 'Relocate',
      id: 'relocate',
      dependency: 'passed_inspection',
      parent: 'new_offices',
      owner: 'Josh'
    }, {
      name: 'Relocate staff',
      id: 'relocate_staff',
      parent: 'relocate',
      start: today + 10 * day,
      end: today + 11 * day,
      owner: 'Mark'
    }, {
      name: 'Relocate test facility',
      dependency: 'relocate_staff',
      parent: 'relocate',
      start: today + 11 * day,
      end: today + 13 * day,
      owner: 'Anne'
    }, {
      name: 'Relocate cantina',
      dependency: 'relocate_staff',
      parent: 'relocate',
      start: today + 11 * day,
      end: today + 14 * day
    }]
  }, {
    name: 'Product',
    data: [{
      name: 'New product launch',
      id: 'new_product',
      owner: 'Peter'
    }, {
      name: 'Development',
      id: 'development',
      parent: 'new_product',
      start: today - day,
      end: today + (11 * day),
      completed: {
        amount: 0.6,
        fill: '#e80'
      },
      owner: 'Susan'
    }, {
      name: 'Beta',
      id: 'beta',
      dependency: 'development',
      parent: 'new_product',
      start: today + 12.5 * day,
      milestone: true,
      owner: 'Peter'
    }, {
      name: 'Final development',
      id: 'finalize',
      dependency: 'beta',
      parent: 'new_product',
      start: today + 13 * day,
      end: today + 17 * day
    }, {
      name: 'Launch',
      dependency: 'finalize',
      parent: 'new_product',
      start: today + 17.5 * day,
      milestone: true,
      owner: 'Peter'
    }]
  }],
  tooltip: {
    pointFormatter: function () {
      var point = this,
        format = '%e. %b',
        options = point.options,
        completed = options.completed,
        amount = isObject(completed) ? completed.amount : completed,
        status = ((amount || 0) * 100) + '%',
        lines;

      lines = [{
        value: point.name,
        style: 'font-weight: bold;'
      }, {
        title: 'Start',
        value: dateFormat(format, point.start)
      }, {
        visible: !options.milestone,
        title: 'End',
        value: dateFormat(format, point.end)
      }, {
        title: 'Completed',
        value: status
      }, {
        title: 'Owner',
        value: options.owner || 'unassigned'
      }];

      return reduce(lines, function (str, line) {
        var s = '',
          style = (
            defined(line.style) ? line.style : 'font-size: 0.8em;'
          );
        if (line.visible !== false) {
          s = (
            '<span style="' + style + '">' +
            (defined(line.title) ? line.title + ': ' : '') +
            (defined(line.value) ? line.value : '') +
            '</span><br/>'
          );
        }
        return str + s;
      }, '');
    }
  },
  title: {
    text: 'Gantt Project Management'
  },
  xAxis: {
    currentDateIndicator: true,
    min: today - 3 * day,
    max: today + 18 * day
  }
});

</script>
    </body>


</html>
