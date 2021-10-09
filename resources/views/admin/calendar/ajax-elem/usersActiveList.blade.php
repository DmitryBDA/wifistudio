<table class="table">
    <thead>
    <tr>
        <th>Дата</th>
        <th>Время</th>
        <th>Имя</th>
    </tr>
    </thead>
    <tbody>
    @foreach($eventList as $event)
        <tr>

            <td>{{ Date::parse($event->start)->format('j.m (D)')}}</td>
            <td>{{$event->title}}</td>
            <td>@if($event->user)
                    {{$event->user->name}} {{$event->user->surname}}
                @endif
            </td>

        </tr>
    @endforeach
    </tbody>
</table>
