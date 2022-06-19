@extends('layouts.user.profile.layout')
@section('title')
    <title>{{ $websiteLang->where('lang_key','wishlist')->first()->custom_text }}</title>
@endsection
@section('user-dashboard')
<div class="row">
    <div class="col-xl-9 ms-auto">
        <div class="wsus__dashboard_main_content">
          <div class="wsus__my_property">
            <h4 class="heading">{{ $websiteLang->where('lang_key','wishlist')->first()->custom_text }}</h4>
            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                    <table class="table">
                      <tr>
                          <th class="image">
                            {{ $websiteLang->where('lang_key','img')->first()->custom_text }}
                        </th>

                        <th class="title">
                            {{ $websiteLang->where('lang_key','property')->first()->custom_text }}
                        </th>

                        <th class="purpose">
                            {{ $websiteLang->where('lang_key','date_added')->first()->custom_text }}
                        </th>

                        <th class="status">
                            {{ $websiteLang->where('lang_key','views')->first()->custom_text }}
                        </th>

                        <th class="actions">
                            {{ $websiteLang->where('lang_key','action')->first()->custom_text }}
                        </th>

                      </tr>

                      @foreach ($wishlists as $item)
                            <tr>
                                <td class="image">
                                    <a href="{{ route('property.details',$item->property->slug) }}">
                                        <img   class="wishlist-image" src="{{ url($item->property->thumbnail_image) }}" alt="img" class="img-fluid">
                                    </a>
                                </td>

                                <td class="title">
                                    <h5> <a href="{{ route('property.details',$item->property->slug) }}">{{ $item->property->title }}</a> </h5>
                                    <p class="address">{{ $item->property->address.', '.$item->property->city->name }}</p>

                                    {{-- @php
                                        $total_review=$item->property->reviews->where('status',1)->count();
                                        if($total_review > 0){
                                            $avg_sum=$item->property->reviews->where('status',1)->sum('avarage_rating');


                                            $avg=$avg_sum/$total_review;
                                            $intAvg=intval($avg);
                                            $nextVal=$intAvg+1;
                                            $reviewPoint=$intAvg;
                                            $halfReview=false;
                                            if($intAvg < $avg && $avg < $nextVal){
                                                $reviewPoint= $intAvg + 0.5;
                                                $halfReview=true;
                                            }

                                        }
                                    @endphp --}}

                                    {{-- @if ($total_review > 0)
                                    <p class="rating">
                                        <span>{{ sprintf("%.1f", $reviewPoint) }}</span>
                                        @for ($i = 1; $i <=5; $i++)
                                            @if ($i <= $reviewPoint)
                                                <i class="fas fa-star"></i>
                                            @elseif ($i> $reviewPoint )
                                                @if ($halfReview==true)
                                                <i class="fas fa-star-half-alt"></i>
                                                    @php
                                                        $halfReview=false
                                                    @endphp
                                                @else
                                                <i class="fal fa-star"></i>
                                                @endif
                                            @endif
                                        @endfor
                                        <span>({{ $total_review }} {{ $websiteLang->where('lang_key','review')->first()->custom_text }})</span>
                                    </p>

                                    @else
                                        <p>
                                            <span>0.0</span>
                                            @for ($i = 1; $i <=5; $i++)
                                            <i class="fal fa-star"></i>
                                            @endfor
                                            <span>({{ 0 }} {{ $websiteLang->where('lang_key','review')->first()->custom_text }})</span>
                                        </p>

                                    @endif --}}
                                </td>

                                <td class="purpose">
                                    <p>{{ $item->created_at->format('Y-m-d') }}</p>
                                </td>

                                <td class="status">
                                    <p>{{ $item->property->views }}</p>
                                </td>

                                <td class="actions">

                                    <ul class="d-flex">

                                        <li><a onclick="return confirm('{{ $websiteLang->where('lang_key','are_you_sure')->first()->custom_text }}')" href="{{ route('user.delete.wishlist',$item->id) }}"><i class="far fa-trash-alt"></i></a></li>

                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                  </table>
                </div>
              </div>
              <div class="col-12 mt_25">
                {{ $wishlists->links('user.paginator') }}
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
