<div class="container">
ТОВАРЫ / УСЛУГИ

<a href="{{ route('products.create') }}" class="btn btn-primary my-2">НОВЫЙ ТОВАР</a>
<hr>
<table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
            <th scope="col">id</th>
            <th scope="col">Артикул</th>
            <th scope="col">Наименование</th>
            <th scope="col">Цена</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($postdata as $item)
            <tr>
                <th scope="row">{{ $item['id'] }}</th>
                <td>{{ $item['item_code'] }}</td>
                <td>{{ $item['item_name'] }}</td>
                <td>{{ $item['price'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>