
@if(isset($projectmessage))
     <div class="chat chat-right" id="chat{{$projectmessage->projectmessage_id}}" data-projectmessageid="{{$projectmessage->projectmessage_id}}">
            <div class="chat-avatar">
                <a href="#" class="avatar">
                    <img class="direct-chat-img" src="{{$projectmessage->fromuser->imagefilepath}}" alt="user image">
                </a>
            </div>

        <div class="chat-body">
            <span class="direct-chat-name pull-right">{{ $projectmessage->fromuser->fullname }}</span>
			<span class="direct-chat-timestamp pull-left">{{ $projectmessage->created_at->format(config('app.constants.dateformat_listing_datetime')) }}</span>
           <div class="chat-bubble">

              <div class="chat-content">
              	<div class="upload-wrapper">
              		
              	</div>
                {{ $projectmessage->message }}
                <span class="chat-time">{{$projectmessage->created_at->format('H:i')}}</span>
              </div>

           </div>
        </div>
     </div>

@endif
