<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "cookiekp500";
$dbname   = "BloodBank";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully <br>";


if(isset($_POST["form1"]))
{
	$donor_id = (int)$_POST["donor_id"];
	$sql = "SELECT * FROM Donor WHERE Donor.donor_id = $donor_id ";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form2"]))
{
	$code = (int)$_POST["location_code"];
	$sql = "SELECT * FROM Bank,  Location  WHERE Location.code = Bank.location_code && Location.code = $code ";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form3"]))
{
	$bg = $_POST["blood_grp"];
	$sql = "SELECT blood_grp_needed, SUM(blood_quant_needed) AS sumx FROM Patient WHERE blood_grp_needed= '$bg'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			//print_r($row);
			echo "blood grp: ". $row["blood_grp_needed"] . " Quantity: " . $row[sumx];
			echo "<br>";
		}
	}
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form4"]))
{
	
	$sql = " SELECT donor_name, SUM(quantity) AS total_donated FROM Donor NATURAL JOIN Blood  GROUP BY (donor_id) ORDER BY total_donated DESC"; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form5"]))
{
	
	$sql = " SELECT patient_name, SUM(blood_quant_needed) AS need FROM Patient GROUP BY (patient_id) ORDER BY need DESC"; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form6"]))
{
	
	$sql = " SELECT  blood_grp_needed, SUM(blood_quant_needed) AS need FROM Patient GROUP BY (blood_quant_needed), blood_grp_needed ORDER BY need  DESC"; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form7"]))
{
	

	$priority = (int)$_POST["rank"];
	$name = $_POST["name"];
	$dat  = strtotime($_POST["date"]);
	$dat = date('Y-m-d',$dat);
	$bg = $_POST["blood_grp_needed"];
	$q = (float)$_POST["quant_needed"];
	$sql = "INSERT INTO Patient(rank, patient_name, date_needed, blood_grp_needed, blood_quant_needed) VALUES($priority,'$name','$dat','$bg',$q)"; 

	if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
	} 
	else {
    	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
else if(isset($_POST["form8"]))
{
	$did = $_POST["did"];
	$sql = " SELECT doctor_name, quantity FROM Blood NATURAL JOIN Doctor WHERE donor_id = $did "; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form9"]))
{
	$dname = $_POST["dname"];
	$sql = "SELECT D.doctor_name, D.rating FROM Doctor D WHERE D.rating > ANY (SELECT D2.rating FROM Doctor D2 WHERE D2.doctor_name = '$dname')"; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form10"]))
{
	$rating = $_POST["rating"];
	$sql = "SELECT D.doctor_name, D.rating FROM Doctor D WHERE D.age > (SELECT MAX(D2.age) FROM Doctor D2 WHERE D2.rating = $rating)"; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form11"]))
{
	$sql = "SELECT DISTINCT B.blood_grp FROM Blood B WHERE NOT EXISTS
(
SELECT * FROM Bank BB WHERE NOT EXISTS 
(

SELECT * FROM Blood BX WHERE BX.bank_id = BB.bank_id AND BX.blood_grp = B.blood_grp
 ))"; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}	
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form12"]))
{
	$bg = $_POST["bg"];
	$sql = "SELECT D.donor_name  FROM Donor D WHERE  EXISTS (SELECT * FROM medicalReport M WHERE M.report_id = D.report_id AND M.blood_grp!='$bg' AND D.appointment_date>=CURDATE())"; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}	
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form13"]))
{
	$mq = $_POST["mq"];
	$n = $_POST["n"];
	$sql = "SELECT D.rating , MIN(D.age) AS MinAge FROM Doctor D WHERE D.qualification>=$mq GROUP BY D.rating HAVING COUNT(*)>=($n-1)"; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}	
	else
	{
		echo "EMPTY <br>";
	}
}
else if(isset($_POST["form14"]))
{
	$bid = (int)$_POST["bid"];
	$sql = "SELECT bank_id2 FROM Transport WHERE bank_id1 = $bid"; 
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			print_r($row);
			echo "<br>";
		}
	}	
	else
	{
		echo "EMPTY <br>";
	}
}






















?>
</body>
</html>