<li @if($Category->parent) class="children-category hide" data-id="{{$Category->parent->id}}" @endif>
    <div class="categories-list row">
        <div data-id="{{$Category->id}}" class="col-md-11 @if($Category->children->count()) have-children @endif">
            <span class="text-center">{{$Category->title}}</span>
        </div>
        <div class="col-md-1">
            <span class="text-right float-right">
                <a href="{{$Category->getUrl()}}" title="More info">
                    <i class="fa fa-eye"></i>
                </a>
                @if(Auth::user()->isUserCan('update'))
                    <a href="{{url('categories/update/' . $Category->id)}}" title="Edit">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                @endif
            </span>
        </div>
    </div>
    @if ($Category->children->count())
        <ul>
            @foreach($Category->children as $children)
                {!! $children->getChildrenHtml($children) !!}
            @endforeach
        </ul>
    @endif
</li>