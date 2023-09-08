@extends('layouts.app')

@section('content')
    <main class="container">
        <section>
            <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="titlebar">
                    <h1>Add Product</h1>
                    <button>Save</button>
                </div>




             @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif




                <div class="card">
                    <div>
                        <label>Title</label>
                        <input type="text" name="name">

                        <label>Description (optional)</label>
                        <textarea cols="10" rows="5" name="description"></textarea>



                        <label>Add Image</label>
                        <img src="" alt="" class="img-product" id="file-previw" />
                        <input type="file" name="image" accept="image/*" onchange="showFile(event)">
                    </div>



                    <div>
                        <label>Category</label>
                        <select name="category">
                            @foreach (json_decode('{"smartphone":"i phone","smart TV":"TV","smartcaptar":"helecuptar","computer":"computer"}', true) as $optionKey => $optionValue)
                                <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                            @endforeach

                        </select>
                        <hr>
                        <label>Inventory</label>
                        <input type="text" name="quentity">
                        <hr>
                        <label>Price</label>
                        <input type="text" name="price">
                    </div>
                </div>
                <div class="titlebar">
                    <h1></h1>
                    <button>Save</button>
                </div>
            </form>

        </section>
    </main>

    <script>
        function showFile(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var output = document.getElementById('file-previw');
                output.src = dataURL;
            }
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
