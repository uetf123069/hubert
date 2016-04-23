
<?php 
    use App\AdminOption; 
?>
@extends('admin.adminLayout')

@section('content')

@include('notification.notify')

<div class="page">

    @if(count($questions) > 0)

        @foreach($questions as $q => $question)

            <?php $options = AdminOption::where('question_id' , $question->id)->get(); ?>
                
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <dl>
                            <dt>{{$question->question}}</dt>

                            <ol> 

                                @if($options) 

                                    @foreach($options as $option)
                                        <li>{{$option->option}}</li> 
                                    @endforeach

                                @endif

                            </ol>

                        </dl>

                    </div>
                </div>

            </div>

        @endforeach

    @endif

    <div class="col-md-12">

        <div class="card">

            <div class="card-body">

                <form class="form" id="form1" action="{{route('adminQuestionProcess')}}" method="post">
                    
                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="question">
                        <input type="hidden" class="form-control"  name="type" value="dropdown">
                        <label for="regular1">Question</label>
                    </div>

                    <div class="col-md-6 form-group">
                        <input type="text" class="form-control" id="option" name="option[1]">
                        <label for="option">Option 1</label>
                    </div>

                    <div class="col-md-6 form-group">
                        <input type="text" class="form-control" id="option" name="option[2]">
                        <label for="option">Option 2</label>
                    </div>

                    <div class="col-md-6 form-group">
                        <input type="text" class="form-control" id="option" name="option[3]">
                        <label for="option">Option 3</label>
                    </div>

                    <div class="col-md-6 form-group">
                        <input type="text" class="form-control" id="option" name="option[4]">
                        <label for="option">Option 4</label>
                    </div>

                    <button type="submit" id="form1_submit_button" class="btn ink-reaction btn-raised btn-primary">
                        Submit
                    </button>

                </form>

            </div>

        </div>

    </div>



</div>

</div>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red">
        <i class="md md-person" style="font-size: 25px;line-height: 65px;"></i>
    </a>
    <ul>

        <li><a class="btn-floating yellow darken-1" href="{{route('adminUserManagement')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-visibility" style="line-height:40px;"></i></a></li>

        <li><a class="btn-floating blue" href="{{route('adminAddUser')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-add" style="line-height:40px;"></i></a></li>

    </ul>

</div>


@stop