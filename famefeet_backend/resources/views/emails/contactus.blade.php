<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Us</title>
</head>
<body>
	<h1>
		Contact Us
	</h1>
    <br>
    <br>
    <p>Name : {{ $contactUs->name }}</p>
    <p>Email : {{ $contactUs->email }}</p>
    <p>Subject : {{ $contactUs->subject }}</p>
    <p>Message : {{ $contactUs->message }}</p>
</body>
</html>
