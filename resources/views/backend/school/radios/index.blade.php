@extends('backend.layouts.master', ['title' => __('School Radio')])

@section('content')
    <div class="container-fluid">
        <radios-component></radios-component>
        <div class="row">
            @foreach ($data ?? [] as $weeklyRadio)
            <div class="col-md-6">
                <div class="mx-3">
                    <table class="table weekly-radios-table">
                        <thead>
                            <tr>
                                <th colspan="5">{{ $weeklyRadio['title'] }}  ({{ $weeklyRadio['formattedWeekRange'] }})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($weeklyRadio['radios'] as $radio)
                            <tr>
                                <td scope="row">{{ $radio->radioDay }}</td>
                                <td>{{ $radio->radioDateFormated }}</td>
                                <td>{{ $radio->class }}</td>
                                <td>{{ $radio->teacher?->name }}</td>
                                <td>
                                    <button type="button" class="primary-button py-1 px-2 me-1" ><ion-icon
                                            name="create-outline"></ion-icon></button>
                                    <button type="button" class="button button-red py-1 px-2"><ion-icon
                                            name="trash-outline"></ion-icon></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection
