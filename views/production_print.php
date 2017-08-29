<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Production</title>
	
	<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>css/preview-style.css' />
	<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>css/preview-print.css' media="print" />
	<script src="<?php echo base_url();?>assets/vendors/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url();?>assets/vendors/html5-form-validation/dist/jquery.validation.min.js"></script>
	<script src="<?php echo base_url();?>assets/vendors/nprogress/nprogress.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/vendors/nprogress/nprogress.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/float-modal.css">
</head>
<body>

	<div id="page-wrap">
	<a href="<?php echo base_url() ?>index.php/ParmarOilMills/web/production/view/<?php echo $id ?>">
		<button id="buttonBack" class = "no-print">Back</button>
	</a>
	<button id = "buttonPrintPage" class = "no-print" onClick="window.print();">Print</button>
	<textarea id="header" readonly></textarea>
	<textarea readonly>Production : <?php echo "PROD".$id ?></textarea>
<div id="identity">	
            <table class="table table-hover nowrap" id="displayProductionsTable" width="100%">
                <thead class="thead-default">
                <tr>
                    <th>Sr No</th>
					<th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody id = 'displayProductionsTableBody'>
				<?php
				$i = 1;
				foreach ($productions as $production): ?>
				<tr>
				    <td><center><?php echo $i; ?></center></td>
					<td><center>OD<?php echo $production['OrderId']; ?></center></td>
                    <td><center><?php echo $production['Name']; ?></center></td>
                    <td><center><?php echo $production['Quantity']; ?></center></td>
				</tr>
				<?php 
				$i++;
				endforeach; ?>
                </tbody>
            </table>
</div>
</body>
</html>

