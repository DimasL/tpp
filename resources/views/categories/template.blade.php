<li @if($Category->parent) class="children-category hide" data-id="{{$Category->parent->id}}" @endif>
    <div class="categories-list">
        <span href="#" data-id="{{$Category->id}}" class="text-center @if($Category->children->count()) have-children @endif">{{$Category->title}}</span>
        <span class="text-right float-right">
        <a href="{{url('categories/view/' . $Category->id)}}" title="More info">
            <i class="fa fa-eye"></i>
        </a>
        @if(Auth::user()->isUserCan('update'))
            <a href="{{url('categories/update/' . $Category->id)}}" title="Edit">
                <i class="fa fa-pencil-square-o"></i>
            </a>
        @endif
    </span>
    </div>
    @if ($Category->children->count())
        <ul>
            @foreach($Category->children as $children)
                {!! $children->getChildrenHtml($children) !!}
            @endforeach
        </ul>
    @endif
</li>