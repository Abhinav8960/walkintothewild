<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Safari Itinerary & Quotation</title>
	<style>
		body {
			font-family: 'Inter', sans-serif;
			margin: 0;
			padding: 20px;
			background-color: #f0f0f0;
			color: #333;
			font-size: 14px;
		}

		.header {
			background-color: #4CAF50;
			color: #fff;
			padding: 15px 25px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			border-top-left-radius: 8px;
			border-top-right-radius: 8px;
		}

		.header h1 {
			margin: 0;
			font-size: 18px;
			font-weight: normal;
		}

		.header .icons {
			font-size: 20px;
		}

		.section {
			padding: 20px 25px;
			margin-bottom: 15px;
			background-color: #f9f9f9;
			border-radius: 8px;
			border: 1px solid #eee;
		}

		.section-title {
			font-size: 16px;
			font-weight: bold;
			margin-bottom: 15px;
			color: #555;
			text-align: center;
		}

	
		.initial-request-details p {
			margin: 5px 0;
			line-height: 1.5;
		}

		.initial-request-details strong {
			display: inline-block;
			width: 120px;
		}

		
		.share-section {
			background-color: #8BC34A;
			color: #fff;
			padding: 15px 25px;
			border-radius: 8px;
			margin-bottom: 15px;
			margin-top: 15px;
			text-align: center;
			font-size: 15px;
			font-weight: bold;
		}

		.form-row {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 10px;
		}

		.form-group {
			flex: 1;
			margin-right: 20px;
		}

		.form-group:last-child {
			margin-right: 0;
		}

		.form-group label {
			display: block;
			font-weight: bold;
			margin-bottom: 5px;
			color: #555;
		}

		.form-group .value-display {
			background-color: #fff;
			border: 1px solid #ddd;
			padding: 8px 12px;
			border-radius: 5px;
			min-height: 20px;
			box-sizing: border-box;
			color: #333;
		}

		.form-group.half-width {
			flex-basis: 48%;
		}

		.form-group.full-width {
			flex-basis: 100%;
		}


		.counter-display {
			display: flex;
			align-items: center;
			justify-content: center;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 5px;
			padding: 8px 12px;
			font-size: 16px;
			font-weight: bold;
			color: #333;
		}

		.date-field {
			display: flex;
			align-items: center;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 5px;
			padding: 8px 12px;
			color: #333;
		}

		.date-field .calendar-icon {
			margin-left: 10px;
			color: #777;
		}


		.additional-notes .value-display {
			min-height: 80px;
			line-height: 1.6;
		}

		/* Final Quote */
		.final-quote {
			text-align: center;
			margin-top: 20px;
			padding: 20px 25px;
			background-color: #e0e0e0;
			border-bottom-left-radius: 8px;
			border-bottom-right-radius: 8px;
		}

		.final-quote label {
			font-size: 18px;
			font-weight: bold;
			color: #555;
			margin-bottom: 10px;
			display: block;
		}

		.final-quote .value-display {
			font-size: 24px;
			font-weight: bold;
			color: #333;
			background-color: #fff;
			border: 1px solid #ccc;
			padding: 10px 20px;
			border-radius: 5px;
			display: inline-block;
		}
	</style>
</head>

<body>

	<div class="header">
		<h1>Apurva - Bandhavgarh Tiger Reserve</h1>
	</div>

	<div class="section initial-request-details">
		<div class="section-title">Initial Request</div>
		<p><strong>Park:</strong> Bandhavgarh Tiger Reserve</p>
		<p><strong>Safaris:</strong> 2</p>
		<p><strong>Travelers:</strong> 2</p>
		<p><strong>Stay Category:</strong> Premium</p>
		<p><strong>Start Date:</strong> Jan 11, 2025</p>
		<p><strong>End Date:</strong> Jan 12, 2025</p>
	</div>

	<div class="share-section">
		Share itinerary & quotation<br>based on the discussion
	</div>

	<div class="section">
		<div class="form-row">
			<div class="form-group full-width">
				<label>Park</label>
				<div class="value-display">Bandhavgarh Tiger Reserve</div>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group half-width">
				<label>Safaris</label>
				<div class="counter-display">0</div>
			</div>
			<div class="form-group half-width">
				<label>Travelers</label>
				<div class="counter-display">0</div>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group full-width">
				<label>Accommodation</label>
				<div class="value-display">Standard</div>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group half-width">
				<label>Start Date</label>
				<div class="date-field">dd-mm-yyyy</div>
			</div>
			<div class="form-group half-width">
				<label>End Date</label>
				<div class="date-field">dd-mm-yyyy</div>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group full-width additional-notes">
				<label>Additional Notes</label>
				<div class="value-display">
					Pick and drop is additional from bla bla airport. We will try for 1 core zone and 1 buffer. In case of unavailability of core zone, we will book best buffer zone possible based on current sightings.
				</div>
			</div>
		</div>
	</div>

</body>

</html>