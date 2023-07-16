@extends('pdf.layout')

@section('content')

    <!-- TITLE -->
    <div style="text-align:center;">
        <h4 style="padding:0;margin:0;">SALESORDER : {{$result->id}}</h4>
        <h5 style="padding:0;margin:0;">Created at : {{date('d/m/Y',strtotime($result->created_at))}}</h5>
    </div>

    <!-- Customer Info -->
    <div style="padding-top:10px; padding-bottom:10px;">
        <table style="width:100%;">
            <tr>
                <td style="vertical-align:top;">
                    <div style="text-align:left;vertical-align:top;">
                        <p class="font-bold" style="padding:0;margin:0;">{{$result->customer->id}}</p>
                        <p class="font-bold" style="padding:0;margin:0;">{{$result->customer->full_name}}</p>
                        <!-- <p style="padding:0;margin:0;">{{$result->customer->defaultaddress->address}}</p> -->
                    </div>
                </td>
                <td style="vertical-align:top;">
                    <div style="text-align:right;vertical-align:top; text-sm;">
                        <p class="font-bold" style="padding:0;margin:0;">Delivery</p>
                        <p style="padding:0;margin:0;">{{$result->delivery && $result->delivery->deliverycontact ? $result->delivery->deliverycontact_name : ''}}</p>
                        <p style="padding:0;margin:0;">{{$result->delivery && $result->delivery->deliveryaddress ? $result->delivery->deliveryaddress_address : ''}}</p>
                    </div>
                </td>
                <td style="vertical-align:top;">
                    <div style="text-align:right;vertical-align:top; text-sm;">
                        <p class="font-bold" style="padding:0;margin:0;">Billing</p>
                        <p style="padding:0;margin:0;">{{$result->billing && $result->billing->billingcontact ? $result->billing->billingcontact_name : ''}}</p>
                        <p style="padding:0;margin:0;">{{$result->billing && $result->billing->billingaddress ? $result->billing->billingaddress_address : ''}}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- OPENING -->
    <div class="">
        <p class="text-justify" style="text-indent: 50px;">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum</p>
    </div>


    <!-- ITEMS -->
    <div class="">
        <table class="tableListData">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result->details as $detail)
                <tr>
                    <td>
                        <div>
                            <p class="font-bold text-md">{{$detail->item_code}}</p>
                            <p class="text-md font-semibold">{{$detail->item_name}}</p>
                            <p class="text-xs" style="margin-top:5px;">{{$detail->item_description}}</p>
                        </div>
                    </td>
                    <td class="">{{$detail->description}}</td>
                    <td class="text-center">{{$detail->qty}}</td>
                    <td class="text-right">{{$detail->unit_price ? $detail->unit_price : '[Not Set]'}}</td>
                    <td class="text-right">{{$detail->unit_price ? $detail->unit_price * $detail->qty : '[Not Set]'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- CLOSING -->
    <div style="page-break-before:auto;">
    <div class="">
        <p class="text-sm" style="margin-top:5px;">{{$result->description}}</p>
    </div>

    <!-- MANUAL APPROVAL -->
    <div class="">
        <table style="width:100%;">
            <tr>
                <td style="width:50%; vertical-align:top;">
                    @if($result->registered_by != $result->finalized_by)
                    <div class="text-center" style=" vertical-align:top;">
                        <p style="margin-bottom:100px;">Created by,</p>
                        <p style="padding:0; margin:0;">{{$result->registered ? $result->registered->name : ''}}</p>
                        <p class="text-sm" style="padding:0; margin:0;">{{$result->registered ? $result->registered->email : ''}}</p>
                    </div>
                    @endif
                </td>
                <td style="width:50%; vertical-align:top;">
                    <div class="text-center" style=" vertical-align:top;">
                        <p style="margin-bottom:100px;">Approved by,</p>
                        <p style="padding:0; margin:0; ">{{$result->finalized ? $result->finalized->name : ''}}</p>
                        <p class="text-sm" style="padding:0; margin:0;">{{$result->finalized ? $result->finalized->email : ''}}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    </div>
@endsection