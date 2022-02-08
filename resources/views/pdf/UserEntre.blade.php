<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
      table {
  border-collapse: collapse;
  border-spacing: 0;
  color: #4a4a4d;
  font: 14px/1.4 "Helvetica Neue", Helvetica, Arial, sans-serif;

}

th, td {
  padding: 10px 15px;
  vertical-align: middle;
}


thead {
  background: #00B1EB;
  color: #fff;
  font-size: 11px;
  text-transform: uppercase;
}

th:first-child {
  border-top-left-radius: 5px;
  text-align: left;
}

th:last-child {
  border-top-right-radius: 5px; 
}

tbody tr:nth-child(even){
  background: #f0f0f2;
}

td {
  border-bottom: 1px solid #cecfd5;
  border-right: 1px solid #cecfd5;
}

td:first-child {
  border-left: 1px solid #cecfd5;
}

.book-title {
  color: #395870;
  display: block;
}

.text-offset {
  color: #7c7c80;
  font-size: 12px;
}

.item-stock,
.item-qty {
  text-align:center;
}

.item-price {
  text-align:right;
}

.item-multiple {
  display: block;
}

tfoot {
  text-align: right;
}

tfoot tr:last-child {
  background: #f0f0f2;
  color: #395870;
  font-weight: bold;
}

tfoot tr:last-child td:first-child {
  border-bottom-left-radius: 5px;
}
tfoot tr:last-child td:last-child {
  border-bottom-right-radius: 5px;
}
header {
  width: 100%;
  height: 50px; 
  display: flex;
  justify-content: space-between;
}
footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  background-color: #00B1EB;
  height: 50px;
}
</style>
</head>
<body>
  <header>  
    <span>Devsoltech</span>
  </header>
    <table style="margin-top: 80px; width:100%;text-align:center;">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Montant</th>
            <th scope="col">La date</th>
            <th scope="col">validation</th>
            <th scope="col">Les charges</th>
            <th scope="col">Désignation</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($entres as $entre)
                <tr>
                    <td>{{ $entre->name }}</td>

                    <td>{{ $entre->montant }} DH</td>
                    <td>{{ $entre->date }}</td>

                    <td>{{ $entre->validation }}</td>

                    @if ($entre->charge == null)
                        <td> ------- </td>
                    @else
                        <td> {{ $entre->charge }} </td>
                    @endif
                    
                    @if ($entre->designiation == null)
                        <td> ------- </td>
                    @else
                        <td> {{ $entre->designiation }} </td>
                    @endif

                </tr>
            @endforeach
        </tbody>
      </table>
      <footer> 
          {{ Carbon\Carbon::now()->format('d/m/y') }}
      </footer>
</body>
</html>