@if($Product->image)
    <img src="{{$message->embed(public_path() . '/assets/images/products/' . $Product->image)}}" alt="{{$Product->title}}">
@endif
New product "<a href="{{$Product->getUrl()}}">{{$Product->title}}</a>" in category "<a href="{{$Category->getUrl()}}">{{$Category->title}}</a>".