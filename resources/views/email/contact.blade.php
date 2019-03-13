<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>

<body>

<p>
  You have received a new message from BM SmartHome website contact form.
</p>
<p>
  Here are the details:
</p>
<ul>
  <li>Name: <strong>{{ $name }}</strong></li>
  <li>Email: <strong>{{ $email }}</strong></li>
</ul>
<hr>
<p>
  @foreach ($messageLines as $messageLine)
    {{ $messageLine }}<br>
  @endforeach
</p>
<hr></body>
<html>
<head>