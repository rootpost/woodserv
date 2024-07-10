<h1>Create PRODUCT</h1>
 
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- Create Post Form -->

<form action="{{ route('products.store') }}" method="post" class="w-75">
  @csrf
  <!--# Производитель #-->
      <div class="form-group w-50">
      Артикул
        <input type="text" class="form-control" id="item_code" name="item_code" placeholder="АРТИКУЛ"></select>
        <span class="text-danger">@error('item_code') {{ $message }}@enderror</span>
      </div>
      <!--# Категория #-->
      <div class="form-group w-50">
      Наименование
        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="НАИМЕНОВАНИЕ"></select>
        <span class="text-danger">@error('item_name') {{ $message }}@enderror</span>
      </div>
      <!--# Описание #-->
      <div class="form-group w-75">
      Описание
        <textarea class="form-control" name="description" id="desc" rows="4"></textarea>
      </div>
      <!--# Price #-->
      <div class="form-group w-50">
      Цена
        <input type="text" class="form-control" id="price" name="price" placeholder="ЦЕНА"></select>
        <span class="text-danger">@error('price') {{ $message }}@enderror</span>
      </div>

      <div class="form-group">
        <input type="submit" id="send" class="btn btn-primary mt-2">
      </div>
</form>