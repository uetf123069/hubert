

<div class="chat">

    <div class="chat-header clearfix">

        @if($sender)
            @if($sender->picture)
                <img  class="user-nav-icon" src="{{ $sender->picture }}" alt="{{ $sender->username }}"/>
            @else
                <img src = "{{asset('/chat/img/user.jpg') }}" style="width: 50px;height: 50px ; border: 3px solid #00ACED" class = "img-circle">
            @endif
        @endif

        <div class="chat-about">
            <div class="chat-with">
                {{tr('chat_with')}} 
                <a href="#"> 
                    {{ $sender->name }} 
                </a>
            </div>
            <div class="chat-num-messages">
                &#64;<a href="#" >{{ $sender->name }} 
                </a>
            </div>
        </div>
    </div>

    <!-- end chat-header -->

    <div class="chat-history" id="history">
        <ul>
            @if(count($messages) > 0)

                @foreach($messages as $m => $message)

                    @if($message->sender_id == $user->id && $message->receiver_id == $sender->id)

                        <li class="clearfix">
                            <div class="message-data align-right">
                                <span class="message-data-time">{{ $message->created_at->diffForHumans()  }}</span> &nbsp; &nbsp;
                                <span class="message-data-name"><a href="#"> {{ $user->name }}</a></span> <i class="fa fa-circle me"></i>

                            </div>
                            <div class="message other-message float-right">
                                {{ $message->message }}
                            </div>
                        </li>

                    @elseif($message->sender_id == $sender->id && $message->receiver_id == $user->id)

                        <li>
                            <div class="message-data">
                                <span class="message-data-name"><i class="fa fa-circle online"></i> <a href="#"> {{ $sender->name}}</a></span>
                                <span class="message-data-time">{{ $message->created_at->diffForHumans()  }}</span>
                            </div>
                            <div class="message my-message">
                                {{ $message->message }}
                            </div>
                        </li>

                    @endif

                @endforeach
            @endif
        </ul>

    </div>

    <!-- end chat-history -->

    <!-- end chat-message -->

</div>