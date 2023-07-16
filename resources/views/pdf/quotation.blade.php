@extends('pdf.layout')

@section('content')

    <!-- TITLE -->
    <div style="text-align:center;">
        <h4 style="padding:0;margin:0;">QUOTATION : {{$result->id}}</h4>
        <h5 style="padding:0;margin:0;">Created at : {{$result->created_at ? date('d/m/Y',strtotime($result->created_at)) : ''}}</h5>
        <h5 style="padding:0;margin:0;">Due Date : {{$result->due_date ? date('d/m/Y',strtotime($result->due_date)) : ''}}</h5>
    </div>

    <!-- Customer Info -->
    <div style="padding-top:10px; padding-bottom:10px;">
        <table style="width:100%;">
            <tr>
                <td>
                    <div style="text-align:left;">
                        <p style="padding:0;margin:0;">Kepada Yth.,</p>
                        <p class="font-bold" style="padding:0;margin:0;">{{$result->customercontact ? $result->customercontact->full_name : ''}}</p>
                        <p style="padding:0;margin:0;">{{$result->customercontact ? $result->customercontact->phone_number : ''}}</p>
                    </div>
                </td>
                <td>
                    <div style="text-align:right;">
                        <p class="font-bold" style="padding:0;margin:0;">{{$result->customer ? $result->customer->id : ''}}</p>
                        <p class="font-bold" style="padding:0;margin:0;">{{$result->customer ? $result->customer->full_name : ''}}</p>
                        <p style="padding:0;margin:0;">{{$result->customer && $result->customer->defaultaddress ? $result->customer->defaultaddress->address : ''}}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- OPENING -->
    <div class="">
        <p class="text-justify text-sm" style="text-indent: 50px;">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum</p>
    </div>


    <!-- ITEMS -->
    <div class="">
        <table class="tableListData">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result->details as $detail)
                <tr>
                    <td>
                        <div><img src="{{public_path($detail->item_image)}}" width="200"></div>
                    </td>
                    <td>
                        <div>
                            <p class="font-bold text-md">{{$detail->item_code}}</p>
                            <p class="text-md font-semibold">{{$detail->item_name}}</p>
                            <p class="text-xs" style="margin-top:5px; white-space:pre-line;">{{$detail->item_description}}</p>
                        </div>
                    </td>
                    <td class="text-center">{{$detail->qty}}</td>
                    <td class="text-right" style="white-space:nowrap;">{{$detail->use_unit_price}}</td>
                    <td class="text-right" style="white-space:nowrap;">{{$detail->use_total_price}}</td>
                </tr>
                @endforeach

                @if($result->ppn)
                <tr>
                    <td colspan="4" class="text-right">TOTAL</td>
                    <td class="text-right" style="white-space:nowrap;">{{$result->total_price}}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">PPn 10%</td>
                    <td class="text-right" style="white-space:nowrap;">{{$result->total_ppn}}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="4" class="text-right">GRAND TOTAL</td>
                    <td class="text-right" style="white-space:nowrap;">{{$result->grand_total}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- TERM AND CONDITION -->
    <div class="">
        <p class="font-semibold text-sm">Terms and Conditions :</p>
        <p class="text-sm" style="white-space:pre-line;">{{$result->term_condition ? $result->term_condition : '-'}}</p>
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