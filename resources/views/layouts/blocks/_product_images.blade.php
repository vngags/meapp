<ul class="list-inline attachments clearfix">

	@if(count($product->attachments) >= 3)
        
            @foreach($product->attachments as $index => $attachment)                 
                    @if($index == 0)
                        <li class="large-image">
                            <a  class="border-outline" href="{{ route('product.show', ['user_slug' => $product->user->slug, 'slug' => $product->slug]) }}">
                                <img src="{{ url('/images/' . $product->user->uid . '/' . FunctionHelper::getImageVersion($attachment->original_url, 'large')) }}" width="200">
                            </a>
                        </li>
                        <li class="small-image">
                    @elseif($index < 3)                         
                        <a class="border-outline" href="{{ route('product.show', ['user_slug' => $product->user->slug, 'slug' => $product->slug]) }}">
                            <img src="{{ url('/images/' . $product->user->uid . '/' . FunctionHelper::getImageVersion($attachment->original_url, 'small')) }}" width="80">
                            @if($index == 2 && count($product->attachments) > 3)
                                <div class="image-count">
                                    <span>+{{ count($product->attachments) - 3 }}</span>
                                </div>
                            @endif
                        </a>                    
                    @endif                    
            @endforeach 
                    </li>
    @elseif(count($product->attachments) == 2) 

        @foreach($product->attachments as $index => $attachment) 
            <li class="half-image">
                <a  class="border-outline" href="{{ route('product.show', ['user_slug' => $product->user->slug, 'slug' => $product->slug]) }}">
                    <img src="{{ url('/images/' . $product->user->uid . '/' . FunctionHelper::getImageVersion($attachment->original_url, 'half')) }}" width="200">
                </a>
            </li>
        @endforeach 

    @else 
            
        @foreach($product->attachments as $index => $attachment) 
            <li class="full-image">
                <a  class="border-outline" href="{{ route('product.show', ['user_slug' => $product->user->slug, 'slug' => $product->slug]) }}">
                    <img src="{{ url('/images/' . $product->user->uid . '/' . FunctionHelper::getImageVersion($attachment->original_url, 'full')) }}" width="200">
                </a>
            </li>
        @endforeach 


    @endif

</ul>