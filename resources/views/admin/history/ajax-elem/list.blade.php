<section class="content">
  <div class="container-fluid">


    <div class="row">
      <div class="col-md-12">
        <div class="timeline">
          @foreach($eventList as $key => $event)
            <div class="time-label">
              <span class="bg-green">{{ Date::parse($key)->format('j.m.Y (D)')}}</span>
            </div>
            <div>
              @foreach($event as $item)
                <div class="timeline-item mb-1">
                  <div class="row">
                    <div class="col-3">
                      <span style="padding-left: 5px" class="time"><i class="fas fa-clock"></i> {{$item['time']}}</span>
                    </div>
                    <div class="col-6">
                      <div class="timeline-body">{{$item['name']}}</div>
                    </div>
                    <div class="col-3">
                      <div class="timeline-footer">
                        <a href="whatsapp://send?phone=+7{{$item['phone']}}" class="time ml-2"><i class="fas fa-envelope"></i></a>
                        <a href="tel:+7{{$item['phone']}}" class="time ml-2"><i class="fas fa-phone"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
      <!-- /.col -->
    </div>
  </div>
  <!-- /.timeline -->

</section>
