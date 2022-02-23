<div class="modal fade" id="showEvaluationStudent" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" faculty="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $evaluationStudent->evaluationClass->class->faculty->getFacultyName() }} |
                    {{ $evaluationStudent->evaluationClass->class->subject->subject_code }} -
                    {{ $evaluationStudent->evaluationClass->class->subject->title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <img src="{{ asset($evaluationStudent->evaluationClass->class->faculty->avatar()) }}" alt="" class="img-thumbnail">
                        </div>
                        <div class="form-group">
                            <label>Faculty:</label>
                            {{ $evaluationStudent->evaluationClass->class->faculty->getFacultyName() }}
                        </div>
                        <div class="form-group">
                            <label>Date Evaluated:</label>
                            {{ date('F d, Y h:i A', strtotime($evaluationStudent->created_at)) }}
                        </div>
                    </div>
                    <div class="col-md-8">
                        @foreach ($evaluationStudent->evaluationStudentReponses as $index => $response)
                        <div class="form-group">
                            <p>{{ ($index+1) . ". " . $response->question }}</p>
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                    @if($response->answer == 'strongly agree') <i class="fas fa-circle"></i> @else <i class="far fa-circle"></i> @endif
                                    <label class="form-check-label" for="stronglyAgree-{{ $response->id }}">Strongly Agree</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    @if($response->answer == 'agree') <i class="fas fa-circle"></i> @else <i class="far fa-circle"></i> @endif
                                    <label class="form-check-label" for="agree-{{ $response->id }}">Agree</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    @if($response->answer == 'disagree') <i class="fas fa-circle"></i> @else <i class="far fa-circle"></i> @endif
                                    <label class="form-check-label" for="disagree-{{ $response->id }}">Disgree</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    @if($response->answer == 'strongly disagree') <i class="fas fa-circle"></i> @else <i class="far fa-circle"></i> @endif
                                    <label class="form-check-label" for="stronglyDisagree-{{ $response->id }}">Strongly Disgree</label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <hr>
                        <div class="form-group">
                            <p>Rating</p>
                            <div class="form-check">
                                <div class="custom-control custom-radio">
                                    <i class="@if($evaluationStudent->rating == '0') fas @else far @endif fa-circle" id="confirm_rating-0"></i>
                                    <label class="form-check-label" for="rating-0">Not Applicable</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <i class="@if($evaluationStudent->rating == '2-3') fas @else far @endif fa-circle" id="confirm_rating-2-3"></i>
                                    <label class="form-check-label" for="rating-2-3">3-2 Needs Improvement</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <i class="@if($evaluationStudent->rating == '5-6') fas @else far @endif fa-circle" id="confirm_rating-5-6"></i>
                                    <label class="form-check-label" for="rating-5-6">5-6 Need to excel  in areas which focuses in the learner centered aspects, good in some areas</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <i class="@if($evaluationStudent->rating == '7-8') fas @else far @endif fa-circle" id="confirm_rating-7-8"></i>
                                    <label class="form-check-label" for="rating-7-8">7-8 Good but need to excel in some areas</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <i class="@if($evaluationStudent->rating == '9-10') fas @else far @endif fa-circle" id="confirm_rating-9-10"></i>
                                    <label class="form-check-label" for="rating-9-10">9-10 Excellent!</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Positive Comments:</label>
                            {{ $evaluationStudent->positive_comments }}
                        </div>
                        <div class="form-group">
                            <label>Negative Comments:</label>
                            {{ $evaluationStudent->negative_comments }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.datetimepicker-no-past').datetimepicker({
            minDate: new Date()
        });
    })
</script>