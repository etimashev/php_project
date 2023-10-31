<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <table>
    <tr>
      <td>AccountId</td>
      <td>{{ $accountid }}</td>
    </tr>
    <tr>
      <td>UserSegment</td>
      <td>{{ $usersegment }}</td>
    </tr>
    <tr>
      <td>Rides</td>
      <td>{{ $rides }}</td>
    </tr>
    <tr>
      <td>Duration</td>
      <td>{{ $duration }}</td>
    </tr>
    <tr>
      <td>Distance</td>
      <td>{{ $distance }}</td>
    </tr>
    <tr>
      <td>LocationCnt</td>
      <td>{{ $locationcnt }}</td>
    </tr>
    <tr>
      <td>LocationName</td>
      <td>{{ implode(', ', $locationname) }}</td>
    </tr>
  </table>
</body>
</html>
