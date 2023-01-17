
@if(isset($projectmessages) && count($projectmessages) > 0)
	@foreach($projectmessages as $row)
		<?php
		$chatbox = "";
		$name = "";
		$namecls = "";
		$datecls = "";
		$img = "";
		$newtag = "";
        // $data['time'] = date('H:i');

        $time = $row->created_at->format('H:i');

		if($auth == $row->from_id) {
			$namecls  = 'pull-right';
			$datecls = 'pull-left';
			$chatbox = 'chat-right';
		} else {
			$namecls  = 'pull-left';
			$datecls = 'pull-right';
			$chatbox = 'chat-left';
			if($row->readstatus == 0) {
				$newtag = '<span class="label label-warning ml10 newtagcls">New</span>';
			}
		}

		if($row->fromuser->imagefilepath != "") {
			$img = $row->fromuser->imagefilepath;
		}
		?>

         <div class="chat {{$chatbox}}" id="chat{{$row->projectmessage_id}}" data-projectmessageid="{{$row->projectmessage_id}}">
            <div class="chat-avatar">
                <a href="#" class="avatar">
                    <img class="direct-chat-img" src="{{$img}}" alt="user image">
                </a>
            </div>
            <div class="chat-body">
                {!! $newtag !!}<span class="direct-chat-name {{$namecls}}">{{ $row->fromuser->firstname." ".$row->fromuser->lastname }}</span>
				<span class="direct-chat-timestamp {{$datecls}}">{{ $row->created_at->format(config('app.constants.dateformat_listing_datetime')) }}</span>
               <div class="chat-bubble">

                  <div class="chat-content">
                  	@if(!$row->projectmedia->isEmpty())
                  		@foreach($row->projectmedia as $key=>$projectmedia)
                  			<div class="file-box file-box'+index+'">
                  				<div>
	                  				<video width="150" controls>
									  	<source src="{{$projectmedia->mediafilepath}}">
									</video>
								</div>
			                    <span class="file-name text-ellipdsis">{{$projectmedia->media_file}}</span>
			                    <div class="d-flex justify-content-between">
			                        <div class="file-size">Size: {{convertToReadableSize($projectmedia->media_size)}}</div>
			                        <div class="file-download">
		                            <a href="{{ url_admin('project-media/download/'.$projectmedia->projectmedia_id) }}" class="fa fa-download" target="_blank"></a></div>
			                    </div>
			                </div>
                  		@endforeach
                  	@endif
                    {{ $row->message }}
                    <span class="chat-time">{{$time}}</span>
                  </div>

               </div>
            </div>
         </div>
	@endforeach
@else
	<div class="nomessagecls2"><i>No messages found!</i></div>
@endif
