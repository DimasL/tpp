@if($Product->image)
    <img src="{{asset('assets/images/products/' . $Product->image)}}" alt="{{$Product->title}}">
@endif
Product "<a href="{{$Product->getUrl()}}">{{$Product->title}}</a>" now is available.