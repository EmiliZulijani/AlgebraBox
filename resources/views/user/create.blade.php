@extends('layouts.index')

@section('title', 'Upload file')

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Upload file</h3>
            </div>
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Create">
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
