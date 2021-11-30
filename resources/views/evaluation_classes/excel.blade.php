<table>
    <thead>
        <tr>
            <th></th>
            <th>Strongly Agree</th>
            <th>Agree</th>
            <th>Disagree</th>
            <th>Strongly Disagree</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($evaluationClass->evaluationStudentResponses()->groupBy('question') as $question => $responses)
            @php
                $labels = ['strongly agree','agree','disagree','strongly disagree'];
                foreach($labels as $label){
                    $answers[$label] = 0;
                }
                foreach($responses as $response){
                    $answers[$response->answer] += 1;
                }
            @endphp
            <tr>
                <td>
                    {{ $question }}
                </td>
                <td>
                    {{ $answers['strongly agree'] }}
                </td>
                <td>
                    {{ $answers['agree'] }}
                </td>
                <td>
                    {{ $answers['disagree'] }}
                </td>
                <td>
                    {{ $answers['strongly disagree'] }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Positive Comments</th>
            <th>Negative Comments</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($evaluationClass->evaluationStudents as $studentResponse)
            <tr>
                <td>
                    {{ $studentResponse->positive_comments }}
                </td>
                <td>
                    {{ $studentResponse->negative_comments }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>