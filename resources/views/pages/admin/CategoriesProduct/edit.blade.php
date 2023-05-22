@extends('admin_layout')
@section('admin_content')
    <div class="card">
        <h5 class="card-header">
            Sửa {{ $messageName }}
        </h5>
            
            
                <div class="card-body">
                    @php
                        $message = session()->get('message');
                        if ($message) {
                            echo '<span class="text-alert">' . $message . '</span>';
                            session()->put('message', null);
                        }
                    @endphp
                    <div class="position-center">
                        <form role="form" method="post" action="{{ route($asRoute . '.update', $each) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="form-label" for="exampleInputEmail1">Tên {{ $messageName }}</label>
                                <input type="text" name="name" value="{{ $each->name }}" class="form-control"
                                    id="exampleInputEmail1" placeholder="tên " . {{ $messageName }} />
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label" for="exampleInputPassword1">Mô tả {{ $messageName }}</label>
                                <textarea class="ckeditor" name="description" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1"
                                    placeholder="mô tả " . {{ $messageName }}>{{ $each->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-info mt-3">Cập nhập</button>
                        </form>
                    </div>
                </div>
            
        
    </div>
    @push('ckeditor_js')
        <script type="text/javascript" src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
        <script>
            CKEDITOR.replaceClass = 'ckeditor'
            CKEDITOR.config.height = 200;
        </script>
    @endpush
@endsection
