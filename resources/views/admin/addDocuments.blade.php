@extends('layouts.admin')

          @if(isset($name))
            @section('title', 'Edit Document Type | ')
          @else
            @section('title', 'Add Document Type | ')
          @endif

@section('content')

@include('notification.notify')
        <div class="panel mb25">
          <div class="panel-heading border">
          @if(isset($name))
          {{ tr('edit_document') }}
          @else
            {{ tr('create_document') }}
          @endif
          </div>
          <div class="panel-body">
            <div class="row no-margin">
              <div class="col-lg-12">
                <form class="form-horizontal bordered-group" action="{{route('adminAddDocumentProcess')}}" method="POST" enctype="multipart/form-data" role="form">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('document_name') }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="document_name" value="{{ isset($document->name) ? $document->name : '' }}" required class="form-control">
                    </div>
                  </div>
                  <input type="hidden" name="id" value="@if(isset($document)) {{$document->id}} @endif" />

                <div class="form-group">
                  <label></label>
                  <div>
                    <button class="btn btn-primary mr10">{{ tr('submit') }}</button>
                  </div>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
@endsection