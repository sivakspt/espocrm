{{#unless onlyContent}}
<li data-id="{{model.id}}" class="list-group-item">
{{/unless}}
    
    <div class="stream-head-container">
        {{{avatar}}}
        <span class="text-muted message">{{{message}}}</span> <a href="javascript:" data-action="expandDetails"><span class="glyphicon glyphicon-chevron-down"></span></a>
    </div>
    
    <div class="hidden details stream-details-container">
        <span>
            {{#each fieldsArr}}
                {{translate field category='fields' scope=../parentType}}: {{{var was ../this}}} &raquo; {{{var became ../this}}}
                <br>
            {{/each}}
        </span>
    </div>
    
    <div class="stream-date-container">
        <span class="text-muted small">{{{createdAt}}}</span>
    </div>

{{#unless onlyContent}}
</li>
{{/unless}}
