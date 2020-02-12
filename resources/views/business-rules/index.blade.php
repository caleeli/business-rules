@extends('layouts.layout')

@section('sidebar')
    @include('layouts.sidebar', ['sidebar'=> Menu::get('sidebar_admin')])
@endsection

@section('content')
    <div class="container page-content" id="app-business-rules" v-cloak>
        <p class="lead">
        <h1>{{ __('Business Rules') }}</h1>
        <div class="row">
            <div class="col">
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    </div>
                    <input v-model="filter" class="form-control" placeholder="{{ __('Search') }}...">
                </div>
            </div>
            <div class="col-8">
                <b-btn v-b-modal.business-rule-modal class="float-right btn-action"><i class="fa fa-plus"></i> {{ __('Business Rule') }}</b-btn>
            </div>
        </div>
        <div class="container-fluid">
            <sample-listing ref="listing" :filter="filter" v-on:reload="reload"></sample-listing>
        </div>

        <b-modal id="business-rule-modal"
                 ref="modal"
                 ok-title="Save"
                 ok-variant="secondary"
                 @ok="onSubmit"
                 @hidden="clearForm"
                 cancel-title="Close"
                 cancel-variant="outline-secondary">
            <h5 slot="modal-header" class="modal-title">@{{ action }} Business Rule</h5>
            <button slot="modal-header" type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            <div class="form-group">
                {!!Form::label('variable', __('Variable'))!!}
                {!!Form::text('variable', null, ['class'=> 'form-control', 'v-model'=> 'formData.variable', 'v-bind:class'
                => '{\'form-control\':true, \'is-invalid\':addError.variable}'])!!}
                <div class="invalid-feedback" v-for="variable in addError.variable" v-text="variable"></div>
            </div>
            <div class="form-group">
                {!!Form::label('condition', __('Condition'))!!}
                {!!Form::text('condition', null, ['class'=> 'form-control', 'v-model'=> 'formData.condition', 'v-bind:class'
                => '{\'form-control\':true, \'is-invalid\':addError.condition}'])!!}
                <div class="invalid-feedback" v-for="condition in addError.condition" v-text="condition"></div>
            </div>
            <div class="form-group">
                {!!Form::label('status', __('Status'))!!}
                {!!Form::select('status', ["ENABLED" => "ENABLED", "DISABLED" => "DISABLED"], null, ['class'=> 'form-control', 'v-model'=> 'formData.status', 'v-bind:class'
                => '{\'form-control\':true, \'is-invalid\':addError.status}'])!!}
                <div class="invalid-feedback" v-for="statusError in addError.status" v-text="statusError"></div>
            </div>

        </b-modal>

    </div>
@endsection

@section('js')
    <script src="{{ mix('/js/package.js', 'vendor/processmaker/packages/business-rules') }}"></script>
@endsection

