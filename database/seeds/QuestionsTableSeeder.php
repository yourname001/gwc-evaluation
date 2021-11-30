<?php

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::insert([
            [
                'question' => "The instructor/s are able to set aside their personal problems or concerns and professionally perform duties during their class.",
                'is_active' => '1'
            ],
            [
                'question' => "The instructor/s are capable of clarifying questions or concerns about their student's activities or their lessons.",
                'is_active' => '1'
            ],
            [
                'question' => "The instructor can support and guide all his students synchronously and asynchronously.",
                'is_active' => '1'
            ],
            [
                'question' => "The instructor shows positive qualities inside and outside the school that students could imbibe.",
                'is_active' => '1'
            ],
            [
                'question' => "The instructor goes to his/her classes with little to no absences/late",
                'is_active' => '1'
            ],
        ]);
        /* Question::insert([
            [
                'question' => 'Speaks clearly and understandably',
                'is_active' => '1'
            ],
            [
                'question' => 'Has good sense of humor',
                'is_active' => '1'
            ],
            [
                'question' => 'Shows enthusiasm and vitality in the classroom',
                'is_active' => '1'
            ],
            [
                'question' => 'Is approachable',
                'is_active' => '1'
            ],
            [
                'question' => 'Treats students equally - does not show favoritism',
                'is_active' => '1'
            ],
            [
                'question' => 'Wears proper decent attire in the classroom',
                'is_active' => '1'
            ],
            [
                'question' => 'Is neat and well - groomed',
                'is_active' => '1'
            ],
            [
                'question' => 'Has updated knowledge on the matter',
                'is_active' => '1'
            ],
            [
                'question' => 'Enriches the lesson through the use of reference materials other than textbook',
                'is_active' => '1'
            ],
            [
                'question' => 'Answers questions in a manner that inspires class confidence in his or her knowledge of the subject matter',
                'is_active' => '1'
            ],
            [
                'question' => 'Possesses a comprehensive and accurate grasp of the subject matter',
                'is_active' => '1'
            ],
            [
                'question' => 'Handles the subject matter with class and logical sequencing of topics',
                'is_active' => '1'
            ],
            [
                'question' => 'Explains the subject matter to the level of the learning experience of students',
                'is_active' => '1'
            ],
            [
                'question' => 'Integrates values and other related fields into the subject matter',
                'is_active' => '1'
            ],
            [
                'question' => 'Begins and ends the lesson with a prayer',
                'is_active' => '1'
            ],
            [
                'question' => 'Shows relationship of the present lesson to the past lesson',
                'is_active' => '1'
            ],
            [
                'question' => 'Explains lessons clearly throught he use of examples and teaching devices such as illustrations and visual aids',
                'is_active' => '1'
            ],
            [
                'question' => 'Adjust lessons techniques to students abilities',
                'is_active' => '1'
            ],
            [
                'question' => 'Enables at least half of the class to understand the subject matter before going to another topic',
                'is_active' => '1'
            ],
            [
                'question' => 'Asks challenging questions to develop in the students the skills for critical thinking',
                'is_active' => '1'
            ],
            [
                'question' => 'Encourages students to ask questions',
                'is_active' => '1'
            ],
            [
                'question' => 'Welcomes varied ideas and opinions related to the subject matter',
                'is_active' => '1'
            ],
            [
                'question' => 'Summarizes the lesson covered toward the end of the period',
                'is_active' => '1'
            ],
            [
                'question' => 'Gives true to life examples of the lesson',
                'is_active' => '1'
            ],
            [
                'question' => 'Requires students to research in the library and use other available resources to enrich the learning process',
                'is_active' => '1'
            ],
            [
                'question' => 'Starts the class on time',
                'is_active' => '1'
            ],
            [
                'question' => 'Dismisses the class on time',
                'is_active' => '1'
            ],
            [
                'question' => 'Looks at the class when explaining the lessonand is able to sustain the interest of the students',
                'is_active' => '1'
            ],
            [
                'question' => 'Comes to class well-prepared for the days lesson',
                'is_active' => '1'
            ],
            [
                'question' => 'Knows the students by their question',
                'is_active' => '1'
            ],
            [
                'question' => 'Respects the students',
                'is_active' => '1'
            ],
            [
                'question' => 'Is respected by the students',
                'is_active' => '1'
            ],
            [
                'question' => 'Encourages the students to study',
                'is_active' => '1'
            ],
            [
                'question' => 'Presents the lesson in a n orderly manner',
                'is_active' => '1'
            ],
            [
                'question' => 'Is patient with students - does not use insulting language',
                'is_active' => '1'
            ],
            [
                'question' => 'Helps the students to discuss issues without being disagreeable ',
                'is_active' => '1'
            ],
            [
                'question' => 'Listens properly to students',
                'is_active' => '1'
            ],
            [
                'question' => 'Acknowledges in class the students who do something good such as answering correctly, proper behavior, etc',
                'is_active' => '1'
            ],
            [
                'question' => 'Uses class time only for subject matter related to the lesson, not for irrelevant topics such as grievances, gossips, etc',
                'is_active' => '1'
            ],
            [
                'question' => 'Has good classroom discipline',
                'is_active' => '1'
            ],
            [
                'question' => 'Conducts Strategic Planning Sessions to align with the Mission and Vision of SJC and develops operational plans as it applies to the discipline',
                'is_active' => '1'
            ],
            [
                'question' => 'Monitors the documentation of work system and process for quality improvement programs',
                'is_active' => '1'
            ],
            [
                'question' => 'Adopts multi-tasking role among faculty members and personnel',
                'is_active' => '1'
            ],
            [
                'question' => 'Reviews policy manual in coordination and is_active participation of faculty and personnel',
                'is_active' => '1'
            ],
            [
                'question' => 'Evaluates the performance of position holders under his or her leadership namagement and gives feedback and evaluation',
                'is_active' => '1'
            ],
            [
                'question' => 'Conducts initial inquiry on reported cases',
                'is_active' => '1'
            ],
            [
                'question' => 'Monitors the implementation of the policy on teaching load, substitution, special classes, and others to ensure effective teaching and learning',
                'is_active' => '1'
            ],
            [
                'question' => 'Demonstrate professional decorum and work ethics through the following: punctuality and attendance; productivity and innovativeness; dedication and commitment to work; and spiritually-quided leadership',
                'is_active' => '1'
            ],
            [
                'question' => 'Manifests compassion and concern for his or her staff, approaches and addresses the concern of his or her subordinates',
                'is_active' => '1'
            ],
            [
                'question' => 'Leads the faculty on excellent classroom management and optimum use of resources to ensure the implementation of standards and accreditation',
                'is_active' => '1'
            ],
            [
                'question' => 'Adheres to school policies and standards',
                'is_active' => '1'
            ],
            [
                'question' => 'Facilitates academic and non-academic achievement(s) in terms of awards or board performances',
                'is_active' => '1'
            ],
            [
                'question' => 'Conducts an assessment and improvement of the Academic Program with the cooperation and the participation of faculty members',
                'is_active' => '1'
            ],
            [
                'question' => 'Ensures relevence of curriculum offering',
                'is_active' => '1'
            ],
            [
                'question' => 'Encourages the optimum instruction technology',
                'is_active' => '1'
            ],
            [
                'question' => 'Recommends faculty as members of the Curriclum Review and Development Community',
                'is_active' => '1'
            ],
            [
                'question' => 'Implements innovative educational approaches and strategies for the transformation of the Discipline as the Center of Excellence',
                'is_active' => '1'
            ],
            [
                'question' => 'Implements faculty development programs that promote faculty competencies to ensure the development of self-directed students',
                'is_active' => '1'
            ],
            [
                'question' => 'Encourages faculty members to pursue advance formal education for professional growth and development',
                'is_active' => '1'
            ],
            [
                'question' => 'Motivates the faculty to yield at least 1 research work per eyar and 1 community extension service per semester',
                'is_active' => '1'
            ],
            [
                'question' => 'Establishes linkages and networking  with affiliating agencies, community, other legal and regulatory agencies and educational institutions',
                'is_active' => '1'
            ],
            [
                'question' => 'Monitors the performance of students through the coordinators and class advisers',
                'is_active' => '1'
            ],
            [
                'question' => 'Collaborates with the Office of the Students Services and the Guidance Office on the total well being, preventive counseling and guidance of students enrolled in the discipline',
                'is_active' => '1'
            ],
            [
                'question' => 'Strengthens alumni networking and linkages for continuous service cooperation',
                'is_active' => '1'
            ]
        ]); */
    }
}
