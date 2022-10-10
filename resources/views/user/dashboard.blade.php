@extends('layouts.user.app')

@section('content')
<section class="dashboard my-5">
    <div class="container">
        <div class="row text-left">
            <div class=" col-lg-12 col-12 header-wrap mt-4">
                <p class="story">
                    DASHBOARD
                </p>
                <h2 class="primary-header ">
                    My Bootcamps
                </h2>
            </div>
        </div>
        <div class="row my-5">
            @include('components.alert')
            <table class="table">
                <tbody>
                    @forelse($checkouts as $checkout)
                        <tr class="align-middle">
                            <td width="18%">
                                <img src="{{ asset('images/item_bootcamp.png') }}" height="120" alt="bootcamp">
                            </td>
                            <td>
                                <p class="mb-2">
                                    <strong>{{ $checkout->camp->title }}</strong>
                                </p>
                                <p>
                                    {{ $checkout->created_at->format('M d, Y') }}
                                </p>
                            </td>
                            <td>
                                <strong>
                                    ${{ $checkout->total }}
                                    @if($checkout->discount_id)
                                        <span class="badge bg-success">
                                            Disc {{ $checkout->discount_percentage }}%
                                        </span>
                                    @endif
                                </strong>
                            </td>
                            <td>
                                <strong>{{ $checkout->payment_status }}</strong>
                            </td>
                            <td>
                                @if($checkout->payment_status == 'waiting')
                                    <a href="{{ $checkout->midtrans_url }}" class="btn btn-primary">Pay here</a>
                                @endif
                            </td>
                            <td>
                                <a href="https://wa.me/08993970968?texx=Hallo, saya sudah membayar bootcamp saya" class="btn btn-primary">
                                    Contact Support !
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No camp register</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
 