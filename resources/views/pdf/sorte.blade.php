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
  background: #395870;
  background: #49708f;
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


</style>
</head>
<body>
    <table style="margin-top: 50px; width:100%;text-align:center;">
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
            @foreach ($sortes as $sorte)
                <tr>
                    <td>{{ $sorte->name }}</td>

                    <td>{{ $sorte->montant }} DH</td>
                    <td>{{ $sorte->date }}</td>

                    <td>{{ $sorte->validation }}</td>

                    @if ($sorte->charge == null)
                        <td> ------- </td>
                    @else
                        <td> {{ $sorte->charge }} </td>
                    @endif
                    
                    @if ($sorte->designiation == null)
                        <td> ------- </td>
                    @else
                        <td> {{ $sorte->designiation }} </td>
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