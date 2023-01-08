@extends('layouts.app')

@section('content')
    <table>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                <td>{{ $invoice->total() }}</td>
                <td>
                    <a href="/order/invoice/{{ $invoice->id }}">Download</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection