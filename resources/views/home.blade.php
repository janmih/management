@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>
                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Graph autorisation absence</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <div class="chartjs-size-monitor">
                                    <div id="autorisatonAbsence" style="width: 100%; height: 300px;"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Autorisaton absence</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="autorisationAbsenceTable" class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Date de début</th>
                                        <th>Date de fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aa as $item)
                                        <tr>
                                            <td>{{ $item['category'] }}</td>
                                            <td>{{ $item['fromDate'] }}</td>
                                            <td>{{ $item['toDate'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Graph congé</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <div class="chartjs-size-monitor">
                                    <div id="conge" style="width: 100%; height: 300px;"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Conge</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="congeTable" class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Date de début</th>
                                        <th>Date de fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aa as $item)
                                        <tr>
                                            <td>{{ $item['category'] }}</td>
                                            <td>{{ $item['fromDate'] }}</td>
                                            <td>{{ $item['toDate'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@section('scripts')
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>
        $('#congeTable').dataTable()
        $('#autorisationAbsenceTable').dataTable()
        // Create root element
        var root = am5.Root.new("autorisatonAbsence");
        root.dateFormatter.setAll({
            dateFormat: "yyyy-MM-dd",
            dateFields: ["valueX", "openValueX"]
        });

        // Set themes
        root.setThemes([am5themes_Animated.new(root)]);

        // Create chart
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "panX",
            wheelY: "zoomX",
            layout: root.verticalLayout
        }));

        // Add legend
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50
        }))

        var colors = chart.get("colors");

        // Create axes
        var yAxis = chart.yAxes.push(
            am5xy.CategoryAxis.new(root, {
                categoryField: "category",
                renderer: am5xy.AxisRendererY.new(root, {
                    inversed: true
                }),
                tooltip: am5.Tooltip.new(root, {
                    themeTags: ["axis"],
                    animationDuration: 200
                })
            })
        );

        var xAxis = chart.xAxes.push(
            am5xy.DateAxis.new(root, {
                baseInterval: {
                    timeUnit: "day",
                    count: 1
                },
                renderer: am5xy.AxisRendererX.new(root, {})
            })
        );

        // Add series
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            xAxis: xAxis,
            yAxis: yAxis,
            openValueXField: "fromDate",
            valueXField: "toDate",
            categoryYField: "category",
            sequencedInterpolation: true
        }));

        series.columns.template.setAll({
            templateField: "columnSettings",
            strokeOpacity: 0,
            tooltipText: "{category}: {openValueX.formatDate('dd-MM-yyyy')} - {valueX.formatDate('dd-MM-yyyy')}"
        });

        series.data.processor = am5.DataProcessor.new(root, {
            dateFields: ["fromDate", "toDate"],
            dateFormat: "dd-MM-yyyy",
            colorFields: ["columnSettings.fill"]
        });

        // Ajout de données
        var data = {!! $data !!};
        data.forEach(function(item) {
            // Récupérer le mois de la date de début
            var month = parseInt(item.fromDate.split('-')[1]); // Extraire le mois
            // Construire la couleur dynamiquement en utilisant la fonction d'AmCharts
            var color = am5.Color.brighten(colors.getIndex(month - 1), 0); // Sélectionner la couleur du mois

            // Ajouter la couleur à la colonneSettings
            item.columnSettings = {
                fill: color
            };
        });
        var categories = [];
        data.forEach(item => {
            if (!categories.includes(item.category)) {
                categories.push(item.category);
            }
        });
        yAxis.data.setAll(categories.map(category => ({
            category
        })));
        series.data.setAll(data);

        // Ajout de barres de défilement
        chart.set("scrollbarX", am5.Scrollbar.new(root, {
            orientation: "horizontal"
        }));

        // Animation au chargement
        series.appear();
        chart.appear(1000, 100);
    </script>
    <script>
        // Create root element
        var root = am5.Root.new("conge");
        root.dateFormatter.setAll({
            dateFormat: "yyyy-MM-dd",
            dateFields: ["valueX", "openValueX"]
        });

        // Set themes
        root.setThemes([am5themes_Animated.new(root)]);

        // Create chart
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "panX",
            wheelY: "zoomX",
            layout: root.verticalLayout
        }));

        // Add legend
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50
        }))

        var colors = chart.get("colors");

        // Create axes
        var yAxis = chart.yAxes.push(
            am5xy.CategoryAxis.new(root, {
                categoryField: "category",
                renderer: am5xy.AxisRendererY.new(root, {
                    inversed: true
                }),
                tooltip: am5.Tooltip.new(root, {
                    themeTags: ["axis"],
                    animationDuration: 200
                })
            })
        );

        var xAxis = chart.xAxes.push(
            am5xy.DateAxis.new(root, {
                baseInterval: {
                    timeUnit: "day",
                    count: 1
                },
                renderer: am5xy.AxisRendererX.new(root, {})
            })
        );

        // Add series
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            xAxis: xAxis,
            yAxis: yAxis,
            openValueXField: "fromDate",
            valueXField: "toDate",
            categoryYField: "category",
            sequencedInterpolation: true
        }));

        series.columns.template.setAll({
            templateField: "columnSettings",
            strokeOpacity: 0,
            tooltipText: "{category}: {openValueX.formatDate('dd-MM-yyyy')} - {valueX.formatDate('dd-MM-yyyy')}"
        });

        series.data.processor = am5.DataProcessor.new(root, {
            dateFields: ["fromDate", "toDate"],
            dateFormat: "dd-MM-yyyy",
            colorFields: ["columnSettings.fill"]
        });

        // Ajout de données
        var data = {!! $data !!};
        data.forEach(function(item) {
            // Récupérer le mois de la date de début
            var month = parseInt(item.fromDate.split('-')[1]); // Extraire le mois
            // Construire la couleur dynamiquement en utilisant la fonction d'AmCharts
            var color = am5.Color.brighten(colors.getIndex(month - 1), 0); // Sélectionner la couleur du mois

            // Ajouter la couleur à la colonneSettings
            item.columnSettings = {
                fill: color
            };
        });
        var categories = [];
        data.forEach(item => {
            if (!categories.includes(item.category)) {
                categories.push(item.category);
            }
        });
        yAxis.data.setAll(categories.map(category => ({
            category
        })));
        series.data.setAll(data);

        // Ajout de barres de défilement
        chart.set("scrollbarX", am5.Scrollbar.new(root, {
            orientation: "horizontal"
        }));

        // Animation au chargement
        series.appear();
        chart.appear(1000, 100);
    </script>
@endsection
@endsection
