<form action="{{ route('evaluation_students.store') }}" method="POST" autocomplete="off">
    @csrf
    <input type="hidden" name="evaluation_class" value="{{ $evaluation_class->id }}">
    <div class="modal fade" id="createEvaluationStudent" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Evaluate</h5>
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
                        </div>
                        <div class="col-md-8">
                            @foreach ($questions as $index => $question)
                            <div class="form-group">
                                <p>{{ ($index+1) . ". " . $question->question }}</p>
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="strongly agree" id="stronglyAgree-{{ $question->id }}" required>
                                        <label class="form-check-label" for="stronglyAgree-{{ $question->id }}">Strongly Agree</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="agree" id="agree-{{ $question->id }}" required>
                                        <label class="form-check-label" for="agree-{{ $question->id }}">Agree</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="disagree" id="disagree-{{ $question->id }}" required>
                                        <label class="form-check-label" for="disagree-{{ $question->id }}">Disgree</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="form-check-input" name="question[{{ $question->id }}]" value="strongly disagree" id="stronglyDisagree-{{ $question->id }}" required>
                                        <label class="form-check-label" for="stronglyDisagree-{{ $question->id }}">Strongly Disgree</label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
            $('.form-check-input:checked').each(function(){
                $('#confirm_'+$(this).attr('id')).removeClass('far')
                $('#confirm_'+$(this).attr('id')).addClass('fas')
            })
            $('#confirm_positive_comments').text($('#positive_comments').val())
            $('#confirm_negative_comments').text($('#negative_comments').val())
            $('#confirmCreateEvaluationStudentModal').modal('show')
        })
    })
</script>