<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title; ?></title>
	<script data-jsfiddle="common" src="<?php echo base_url(); ?>assets/vendor/handsontable/demo/js/jquery.min.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

	<link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/vendor/handsontable/dist/handsontable.css">
	<link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/vendor/handsontable/dist/pikaday/pikaday.css">
	<script data-jsfiddle="common" src="<?php echo base_url(); ?>assets/vendor/handsontable/dist/pikaday/pikaday.js"></script>
	<script data-jsfiddle="common" src="<?php echo base_url(); ?>assets/vendor/handsontable/dist/moment/moment.js"></script>
	<script data-jsfiddle="common" src="<?php echo base_url(); ?>assets/vendor/handsontable/dist/numbro/numbro.js"></script>
	<script data-jsfiddle="common" src="<?php echo base_url(); ?>assets/vendor/handsontable/dist/numbro/languages.js"></script>
	<script data-jsfiddle="common" src="<?php echo base_url(); ?>assets/vendor/handsontable/dist/handsontable.js"></script>
</head>
<body>
	
	<div class="container">
		<div class="mt-5">
			<button name="load" class="btn btn-info">Load</button>
			<button name="save" class="btn btn-info">Save</button>
			<button name="reset" class="btn btn-info">Reset</button>
			<label><input type="checkbox" name="autosave" checked="checked" autocomplete="off"> Autosave</label>
		</div>

		<div id="exampleConsole" class="console">Click "Load" to load data from server</div>

		<div id="example1"></div>

		<div class="mt-5">
			<button name="dump" data-dump="#example1" data-instance="hot" title="Prints current data source to Firebug/Chrome Dev Tools" class="btn btn-info">
              Dump data to console
            </button>
		</div>
	</div>

	<script>
            var
              $container = $("#example1"),
              $console = $("#exampleConsole"),
              $parent = $container.parent(),
              autosaveNotification,
              hot;

            hot = new Handsontable($container[0], {
              columnSorting: true,
              startRows: 8,
              startCols: 3,
              rowHeaders: true,
              colHeaders: ['Manufacturer', 'Year', 'Price'],
              columns: [
                {},
                {},
                {}
              ],
              minSpareCols: 0,
              minSpareRows: 1,
              contextMenu: true,
              afterChange: function (change, source) {
                var data;

                if (source === 'loadData' || !$parent.find('input[name=autosave]').is(':checked')) {
                  return;
                }
                data = change[0];

                // transform sorted row to original row
                data[0] = hot.sortIndex[data[0]] ? hot.sortIndex[data[0]][0] : data[0];

                clearTimeout(autosaveNotification);
                $.ajax({
                  url: '<?php echo base_url(); ?>cars/save',
                  dataType: 'json',
                  type: 'POST',
                  data: {changes: change}, // contains changed cells' data
                  success: function () {
                    $console.text('Autosaved (' + change.length + ' cell' + (change.length > 1 ? 's' : '') + ')');

                    autosaveNotification = setTimeout(function () {
                      $console.text('Changes will be autosaved');
                    }, 1000);
                  }
                });
              }
            });

            $parent.find('button[name=load]').click(function () {
              $.ajax({
                url: '<?php echo base_url(); ?>cars/load',
                dataType: 'json',
                type: 'GET',
                success: function (res) {
                  var data = [], row;

                  for (var i = 0, ilen = res.cars.length; i < ilen; i++) {
                    row = [];
                    row[0] = res.cars[i].manufacturer;
                    row[1] = res.cars[i].year;
                    row[2] = res.cars[i].price;
                    data[res.cars[i].id - 1] = row;
                  }
                  $console.text('Data loaded');
                  hot.loadData(data);
                }
              });
            }).click(); // execute immediately

            $parent.find('button[name=save]').click(function () {
              $.ajax({
                url: '<?php echo base_url(); ?>cars/save',
                data: {data: hot.getData()}, // returns all cells' data
                dataType: 'json',
                type: 'POST',
                success: function (res) {
                  if (res.result === 'ok') {
                    $console.text('Data saved');
                  }
                  else {
                    $console.text('Save error');
                  }
                },
                error: function () {
                  $console.text('Save error');
                }
              });
            });

            $parent.find('button[name=reset]').click(function () {
              $.ajax({
                url: '<?php echo base_url(); ?>cars/reset',
                success: function () {
                  $parent.find('button[name=load]').click();
                },
                error: function () {
                  $console.text('Data reset failed');
                }
              });
            });

            $parent.find('input[name=autosave]').click(function () {
              if ($(this).is(':checked')) {
                $console.text('Changes will be autosaved');
              }
              else {
                $console.text('Changes will not be autosaved');
              }
            });
          </script>

</body>
</html>