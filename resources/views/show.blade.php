@extends('rss-reader::layout')

@section('content')
    <div ng-controller="EntryController as entry">
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <div class="input-group">
                        <input id="feed-url-input" type="text" class="form-control" placeholder="Adres kanału RSS" ng-model="entry.url"/>
                        <div id="feed-url-button" class="input-group-addon btn btn-default" ng-click="entry.update(entry.url)"><i class="fa fa-search"></i><span>Aktualizuj</span></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="btn btn-success" ng-click = "entry.type = 'create'; entry.focus = {title: 'Nowy wpis', content: 'Treść nowego wpisu'}" data-toggle="modal" data-target="#editFormModal">Dodaj nowy element</div>
            </div>
        </div>

        <div id="feed-entries">
            <div class="panel panel-default" ng-repeat="element in entry.list" data-id="@{{ element.id }}">
                <div class="panel-heading"><a href="@{{ element.url }}">@{{ element.title  }}</a></div>
                <div class="panel-body" ng-bind-html="entry.renderHtml(element.content)"></div>
                <div class="panel-footer">
                    <span class="label label-info">źródło: @{{ element.source }}</span> <span class="label label-primary">utworzony: @{{ element.created_at }} </span> <span ng-if="element.updated_at" class="label label-primary">aktualizowany: @{{ element.updated_at }}</span>
                    <span class="label label-success clickable pull-right" ng-click="entry.type = 'update'; entry.focus = element;" data-toggle="modal" data-target="#editFormModal">Edytuj</span> <span ng-click="entry.del(element.id)" class="label label-danger clickable pull-right">Usuń</span>
                </div>
            </div>
        </div>
        @include('rss-reader::editForm')
    </div>
@endsection
