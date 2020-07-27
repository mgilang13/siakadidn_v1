<form action="{{ route($route) }}" method="get">
    <div class="form-group row justify-content-center mt-3">
        <label class="col-md-2 d-flex justify-content-md-end justify-content-center col-form-label" for="q">Periode</label>
        <div class="col-md-3">
            <input class="form-control" type="date" name="{{ $name }}" value="{{ $past_date }}">
        </div>
        <div class="col-md-3">
            <input class="form-control" type="date" name="present_date" value="{{ $present_date }}">
        </div>
        <button class="btn-indigo rounded btn-sm btn mt-md-n1 ml-md-n2" type="submit" id="button-search">
            <i width="14" class="" data-feather="search"></i>
        </button>
    </div>
</form>