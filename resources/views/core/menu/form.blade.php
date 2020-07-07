<!-- Modal -->
<form action="" method="post">
    @csrf
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Parent Menu</label>
                        <select name="parent" class="form-control" id="parent">
                            <option value=""></option>
                            {!! $rs_option !!}
                        </select>
                        <div class="invalid-feedback" id="parent-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Judul Menu</label>
                        <input type="text" name="title" class="form-control" id="title">
                        <div class="invalid-feedback" id="title-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nama Route</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <div class="invalid-feedback" id="name-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="icon" class="col-form-label">Icon</label>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name="icon" class="form-control" id="icon">
                                <div class="invalid-feedback" id="icon-message"></div>
                            </div>
                            <div class="col-6">
                                <div class="dropdown dropright">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownAdd">
                                        Daftar Icon
                                    </button>
                                    <div class="dropdown-menu dropdown-icon" aria-labelledby="dropdownAdd" style="height: 200px; overflow: scroll; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(104px, -163px, 0px);">
                                        @foreach ($rs_icon as $icon)
                                            @if ($icon != '')
                                                <a href="#" class="m-2 icon" data-icon="{{ $icon }}">
                                                    <i width="14" class="mr-2" data-feather="{{ $icon }}"></i>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order" class="col-form-label">Urutan Menu</label>
                        <input type="number" name="order" class="form-control" id="order">
                        <div class="invalid-feedback" id="order-message"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn">Reset</button>
                    <button type="su!bmit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>