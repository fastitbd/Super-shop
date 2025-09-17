@extends('frontend.layouts.website')
@section('content')

<div class="container my-5">
  <div class="wishlist-wrapper bg-white p-4 rounded shadow-sm">

    @if(count($wishlistItems) > 0)
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">My Wishlist</h3>
        <button id="addAllToCart" class="btn btn-success btn-sm">
          <i class="fa-solid fa-cart-plus me-1"></i> Add All to Cart
        </button>
      </div>

      @foreach($wishlistItems as $item)
        <div class="wishlist-item d-flex align-items-center mb-3 p-3 border rounded shadow-sm bg-light">
          
          {{-- Image --}}
          <div class="wishlist-img me-3">
            <img src="{{ asset('uploads/products/' . $item->images) }}" 
                 alt="{{ $item->name }}" 
                 class="rounded"
                 width="90" height="90">
          </div>

          {{-- Details --}}
          <div class="wishlist-details flex-grow-1">
            <h5 class="wishlist-title mb-1">{{ $item->name }}</h5>
            <div>
              <span class="wishlist-price text-success fw-bold">৳ {{ $item->selling_price }}</span>
              @if($item->discount)
                <span class="wishlist-old-price text-muted text-decoration-line-through ms-2">
                  ৳ {{ $item->selling_price + $item->discount }}
                </span>
              @endif
            </div>
          </div>

          {{-- Actions --}}
          <div class="wishlist-actions d-flex align-items-center gap-2">
            {{-- Single Add to Cart --}}
            <button class="btn btn-primary btn-sm add-to-cart-single" data-id="{{ $item->id }}">
              অর্ডার করুন
            </button>

            {{-- Remove from wishlist --}}
            <button class="btn btn-danger btn-sm remove-btn" data-id="{{ $item->id }}">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </div>
      @endforeach

    @else
      <div class="text-center my-5">
        <h3>Your wishlist is empty!</h3>
        <a href="{{ route('home') }}" class="btn btn-warning mt-3">Shop Now</a>
      </div>
    @endif

  </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){

    // Remove single wishlist item
    $(document).on('click', '.remove-btn', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let btn = $(this);

        $.ajax({
            url: "{{ route('wishlist.remove') }}",
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", id: id },
            success: function(res){
                if(res.status === 200){
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Remove item from UI
                    btn.closest('.wishlist-item').remove();

                    // If wishlist empty, show message
                    if($('.wishlist-item').length === 0){
                        $('.wishlist-wrapper').html(
                            '<div class="text-center my-5"><h3>Your wishlist is empty!</h3><a href="{{ route('home') }}" class="btn btn-warning mt-3">Shop Now</a></div>'
                        );
                    }
                }
            }
        });
    });

    // Add single product to cart
    $(document).on('click', '.add-to-cart-single', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let btn = $(this);

        $.ajax({
            url: "{{ route('cart.store') }}",
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", id: id, quantity: 1 },
            success: function(res){
                if(res.status === 'success'){
                    $('#cart-count').text(res.cart_count); // update cart count
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                     // Auto reload to sync frontend with session
                setTimeout(function(){
                    location.reload();
                }, 500); // 0.5 sec delay for smooth toast

                    // Remove item from wishlist UI
                    btn.closest('.wishlist-item').remove();

                    // If wishlist empty, show message
                    if($('.wishlist-item').length === 0){
                        $('.wishlist-wrapper').html(
                            '<div class="text-center my-5"><h3>Your wishlist is empty!</h3><a href="{{ route('home') }}" class="btn btn-warning mt-3">Shop Now</a></div>'
                        );
                    }
                }
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Could not add to cart'
                });
            }
        });
    });

    // Add all wishlist items to cart
    $('#addAllToCart').on('click', function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ route('wishlist.addAllToCart') }}",
            type: 'POST',
            data: { _token: "{{ csrf_token() }}" },
            success: function(res){
                if(res.status === 200){
                    $('#cart-count').text(res.cart_count);

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                     // Auto reload to sync frontend with session
                setTimeout(function(){
                    location.reload();
                }, 500); // 0.5 sec delay for smooth toast

                    // Clear wishlist visually
                    $('.wishlist-wrapper').html(
                        '<div class="text-center my-5"><h3>Your wishlist is empty!</h3><a href="{{ route('home') }}" class="btn btn-warning mt-3">Shop Now</a></div>'
                    );
                }
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Something went wrong!'
                });
            }
        });
    });

});
</script>

@endpush
