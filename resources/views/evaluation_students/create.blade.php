<form action="{{ route('evaluation_students.store') }}" method="POST" autocomplete="off">
    @csrf
    <input type="hidden" name="evaluation_class" value="{{ $evaluation_class->id }}">
    <div class="modal fade" id="createEvaluationStudent" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Evaluate {{ $evaluation_class->class->faculty->fullname('') }}</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <img src="{{ asset($evaluation_class->class->faculty->avatar()) }}" alt="" class="img-thumbnail">
                            </div>
                            <div class="form-group">
                                <label>Faculty:</label>
                                {{ $evaluation_class->class->faculty->fullname('') }}
                            </div>
                            <div class="form-group">
                                <label>Subject:</label>
                                {{ $evaluation_class->class->subject->subject_code }} |
                                {{ $evaluation_class->class->subject->title }}
                            </div>
                        </div>
                        <div class="col-md-8">
                            @foreach ($questions as $index => $question)
                            <div class="form-group">
                                <p>{{ ($index+1) . ". " . $question->question }}</p>
                                {{-- <div class="form-check form-check-inline"> --}}
                                    <div class="icheck-primary">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="strongly agree" id="stronglyAgree-{{ $question->id }}" required>
                                        <label for="stronglyAgree-{{ $question->id }}">Strongly Agree</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="agree" id="agree-{{ $question->id }}" required>
                                        <label for="agree-{{ $question->id }}">Agree</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="disagree" id="disagree-{{ $question->id }}" required>
                                        <label for="disagree-{{ $question->id }}">Disgree</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="strongly disagree" id="stronglyDisagree-{{ $question->id }}" required>
                                        <label for="stronglyDisagree-{{ $question->id }}">Strongly Disgree</label>
                                    </div>
                                {{-- </div> --}}
                            </div>
                            @endforeach
                            <hr>
                            <div class="form-group">
                                <p>Rating</p>
                                <div class="form-check">
                                    <div class="icheck-primary">
                                        <input type="radio" name="rating" value="1-2" id="rating-1-2" required>
                                        <label for="rating-1-2">1-2 Poor</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" name="rating" value="3-4" id="rating-3-4" required>
                                        <label for="rating-3-4">3-4 Needs Improvement</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" name="rating" value="5-6" id="rating-5-6" required>
                                        <label for="rating-5-6">5-6 Need to excel  in areas which focuses in the learner centered aspects, good in some areas</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" name="rating" value="7-8" id="rating-7-8" required>
                                        <label for="rating-7-8">7-8 Good but need to excel in some areas</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" name="rating" value="9-10" id="rating-9-10" required>
                                        <label for="rating-9-10">9-10 Excellent!</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>Positive Comments:</label>
                                <textarea class="form-control" name="positive_comments" id="positive_comments" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Negative Comments:</label>
                                <textarea class="form-control" name="negative_comments" id="negative_comments" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" type="button" id="confirmCreateEvaluationStudent"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmCreateEvaluationStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure do you want to submit this evaluation?</h5>
                    <button type="button" class="close" data-dismiss="modal" data-target="#confirmCreateEvaluationStudentModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <img src="{{ asset($evaluation_class->class->faculty->avatar()) }}" alt="" class="img-thumbnail">
                            </div>
                            <div class="form-group">
                                <label>Faculty:</label>
                                {{ $evaluation_class->class->faculty->fullname('') }}
                            </div>
                        </div>
                        <div class="col-md-8">
                            @foreach ($questions as $index => $question)
                            <div class="form-group">
                                <p>{{ ($index+1) . ". " . $question->question }}</p>
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <i class="far fa-circle" id="confirm_stronglyAgree-{{ $question->id }}"></i>
                                        <label class="form-check-label">Strongly Agree</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <i class="far fa-circle" id="confirm_agree-{{ $question->id }}"></i>
                                        <label class="form-check-label">Agree</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <i class="far fa-circle" id="confirm_disagree-{{ $question->id }}"></i>
                                        <label class="form-check-label">Disgree</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <i class="far fa-circle" id="confirm_stronglyDisagree-{{ $question->id }}"></i>
                                        <label class="form-check-label">Strongly Disgree</label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <hr>
                            <div class="form-group">
                                <p>Rating</p>
                                <div class="form-check">
                                    <div class="custom-control custom-radio">
                                        <i class="far fa-circle" id="confirm_rating-1-2"></i>
                                        <label class="form-check-label" for="rating-1-2">1-2 Poor</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <i class="far fa-circle" id="confirm_rating-3-4"></i>
                                        <label class="form-check-label" for="rating-3-4">3-4 Needs Improvement</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <i class="far fa-circle" id="confirm_rating-5-6"></i>
                                        <label class="form-check-label" for="rating-5-6">5-6 Need to excel  in areas which focuses in the learner centered aspects, good in some areas</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <i class="far fa-circle" id="confirm_rating-7-8"></i>
                                        <label class="form-check-label" for="rating-7-8">7-8 Good but need to excel in some areas</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <i class="far fa-circle" id="confirm_rating-9-10"></i>
                                        <label class="form-check-label" for="rating-9-10">9-10 Excellent!</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>Positive Comments:</label>
                                <p id="confirm_positive_comments"></p>
                            </div>
                            <div class="form-group">
                                <label>Negative Comments:</label>
                                <p id="confirm_negative_comments"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" data-target="#confirmCreateEvaluationStudentModal">Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function(){
        $('.datetimepicker-no-past').datetimepicker({
            minDate: new Date()
        });

        $('#confirmCreateEvaluationStudent').on('click', function(){
            $('.icheck-primary input').each(function(){
                $('#confirm_'+$(this).attr('id')).removeClass('fas')
                $('#confirm_'+$(this).attr('id')).addClass('far')
            })
            $('.icheck-primary input:checked').each(function(){
                $('#confirm_'+$(this).attr('id')).removeClass('far')
                $('#confirm_'+$(this).attr('id')).addClass('fas')
            })
            $('#confirm_positive_comments').text($('#positive_comments').val())
            $('#confirm_negative_comments').text($('#negative_comments').val())
            $('#confirmCreateEvaluationStudentModal').modal('show')
        })
    })
</script>