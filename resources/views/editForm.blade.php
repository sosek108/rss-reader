<div id="editFormModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edytuj - @{{ entry.focus.title }}</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="title-input">Tytuł</label>
            <input ng-model="entry.focus.title" type="text" id="title-input" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="title-input">Treść</label>
            <textarea ng-model="entry.focus.content" id="title-input" class="form-control" ></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="element = old">Zamknij</button>
        <button ng-if="entry.type == 'update'" type="button" class="btn btn-primary" ng-click="entry.update(entry.focus)">Zapisz</button>
        <button ng-if="entry.type == 'create'" type="button" class="btn btn-primary" ng-click="entry.create(entry.focus)">Zapisz</button>
      </div>
    </div>
  </div>
</div>