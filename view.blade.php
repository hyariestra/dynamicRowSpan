<!DOCTYPE html>
<html>
<head>
<style>
table.border, td.border, th.border {
    border: 1px solid #000000;
    border-collapse: collapse;
}
header{
    text-align: center;
    border-bottom: 4px solid #000000;
}
</style>
</head>
<body>
<header>
    <!-- <img aligin="left" src="{{ public_path().'/uploads/indef.png' }}" width="20%" height="20%"/> -->
    <img src="{{ public_path().'/logo/logoindef2.png' }}" width="20%" height="20%"/>
    <p><strong>PROJECT PROGRESS REPORT</strong><br>ITS Tower Lt. 8 Jl. Raya Pasar Minggu KM.18<br>
    Pejaten Timur, Pasar Minggu Jakarta, Indonesia 12510 </p>
</header>
<p align="right"><i>Report Date : {{ Carbon\Carbon::parse($dateNow)->format('j-M-Y') }}</i></p>
<br>
<table>
<tr>
    <td><strong>OVERVIEW</strong></td>
</tr>
<tr>
    <td>Project Name</td>
    <td>:</td>
    <td>{{$project->project_name}}</td>
</tr>
<tr>
    <td>Client</td>
    <td>:</td>
    <td>{{$project->client_name}}</td>
</tr>
<tr>
    <td>Project Leader</td>
    <td>:</td>
    <td>{{$project->employee->employee_name}}</td>
</tr>
<tr>
    <td>Type</td>
    <td>:</td>
    <td>Commercial</td>
</tr>
<tr>
    <td>Category</td>
    <td>:</td>
    <td>{{$project->category->project_category_name}}</td>
</tr>
<tr>
    <td>Status</td>
    <td>:</td>
    <td>
        @switch($project->status)
        @case(1)
            Seleksi
            @break
        @case(2)
            Lolos Seleksi
            @break
        @case(3)
            Start
            @break
        @case(4)
            In Progress
            @break
        @case(5)
            Midterm Report
            @break
        @case(6)
            Final Report
            @break
        @case(7)
            Menunggu Pencairan
            @break
        @case(8)
            Finish
            @break
        @case(9)
            Closed
            @break
        @case(10)
            Gagal Seleksi
            @break
        @endswitch
    </td>
</tr>
<tr>
    <td>Start Date</td>
    <td>:</td>
    <td>{{ Carbon\Carbon::parse($project->start_date)->format('j-M-Y') }}</td>
</tr>
<tr>
    <td>End Date</td>
    <td>:</td>
    <td>{{ Carbon\Carbon::parse($project->end_date)->format('j-M-Y') }}</td>
</tr>
<tr>
    <td>Description</td>
    <td>:</td>
    <td>{{$project->description}}</td>
</tr>
<tr>
    <td>Project Progress</td>
    <td>:</td>
    <td>{{$progressBar}}%</td>
</tr>
</table>

<br>

<table cellpadding="7" class="border">
<caption style="text-align:left"><b>PROJECT MEMBER</b><caption>
<tr class="border">
    <th class="border">Member Name</th>
    <th class="border">Position</th>
    <th class="border">Status</th>
    <th class="border">Task Completed</th>
    <th class="border">Task Uncompleted</th>
    <th class="border">Rating</th>
</tr>
@if($member->count() == '0')
    <tr><td colspan="6" style="text-align:center;">There is no data to display </td></tr>
@else
@foreach($member as $data)
<?php 
    $id = $project->project_id;
?>
<tr class="border">
    <td class="border">{{ $data->employee->employee_name }}</td>
    <td class="border">{{ $data->position }}</td>
    <td class="border">
    @if ($data->status == '0')
        Reject
    @elseif ($data->status == '1')
        Pending
    @elseif ($data->status == '2')
        Approve
    @endif
    </td>
    <td class="border">{{ count($data->task()->where('task_projects.status','=','Completed')) }}</td>
    <td class="border">{{ count($data->task()->where('task_projects.status','=','Incompleted')) }}</td>
    <td class="border">{{ $data->rating }}</td>
</tr>
@endforeach
@endif
</table>

<br>

<table cellpadding="7" class="border">
<caption style="text-align:left"><b>PROJECT TASK</b><caption>
<tr class="border">
    <th class="border">Task</th>
    <th class="border">Description</th>
    <th class="border">Deadline</th>
    <th class="border">Member</th>
    <th class="border">Status</th>
</tr>
@if($task->count() == '0')
    <tr><td colspan="5" style="text-align:center;">There is no data to display </td></tr>
@else
@foreach($task as $data)
<tr class="border">
    <td class="border">{{ $data->task_title }}</td>
    <td class="border">{{ $data->description }}</td>
    <td class="border">{{ Carbon\Carbon::parse($data->deadline)->format('j-M-Y') }}</td>
    <td class="border">{{ $data->member->employee->employee_name }}</td>
    <td class="border">{{ $data->status }}</td>
</tr>
@endforeach
@endif
</table>

<br>

<table cellpadding="7" class="border">
<caption style="text-align:left"><b>PROJECT FILE</b><caption>
<tr class="border">
    <th class="border">Description</th>
    <th class="border">File Type</th>
    <th class="border">File</th>
</tr>
@if($file->count() == '0')
    <tr><td colspan="3" style="text-align:center;">There is no data to display </td></tr>
@else
@foreach($file as $data)
<tr class="border">
    <td class="border">{{ $data->description }}</td>
    <td class="border">
    @switch($data->file_type)
        @case(1)
            Proposal
            @break
        @case(2)
            Mid Term Report
            @break
        @case(3)
            Final Term Report
            @break
        @case(4)
            Other File
            @break
    @endswitch
    </td>
    <td class="border">{{ $data->file_name_path }}</td>
</tr>
@endforeach
@endif
</table>

<br>

<table cellpadding="7" class="border">
<caption style="text-align : left"><b>PROJECT EXPENSE</b></caption>
  <tr class="border">
    <th class="border" rowspan="2">Date</th>
    <th class="border" colspan="3" align="center">Detail Transaction</th>
    <th class="border" rowspan="2">Total</th>
    <th class="border" rowspan="2">Memo</th>
    <th class="border" rowspan="2">Source</th>
    <th class="border" rowspan="2">Status</th>
</tr>
<tr class="border">
    <th class="border">Expense Category</th>
    <th class="border">Description</th>
    <th class="border">Nominal</th>
</tr>

 


@if($detail->count() == '0')
    <tr><td colspan="7" style="text-align:center;">There is no data to display </td></tr>
@else


  <?php 
 $no=1;
 $array = 1;
 $display = '';
/*  echo '<pre>';
    print_r ($report);
        echo '<pre>';
exit();*/
 for ($i = 0; $i < count($detail); $i++)
  { 
  
   $num =   DB::table('detail_expenses')
    ->where('expense_project_id', '=', $detail[$i]['expense_project_id'])->count();


    ?>

    <tr  class="border">
        <td class="border">{{$detail[$i]['expense_project']['date']}}</td>
        <td class="border">{{ $detail[$i]['expense_category']['expense_name'] }}</td>
        <td class="border">{{ $detail[$i]['description']}}</td>
        <td class="border">Rp. {{number_format($detail[$i]['nominal'],2,",",".")}}</td>
        <td style="border-bottom: 1px solid black;display: <?php echo $display;?>"  rowspan="<?php echo $num ?> class="border">Rp. {{number_format($total,2,",",".")}}</td>
        <td style="border-bottom: 1px solid black;display: <?php echo $display;?>"  rowspan="<?php echo $num ?> class="border">{{$detail[$i]['expense_project']['memo']}}</td>
        <td style="border-bottom: 1px solid black;display: <?php echo $display;?>"  rowspan="<?php echo $num ?> class="border">{{$detail[$i]['expense_project']['source']}}</td>
        <td border style="border-bottom: 1px solid black;display: <?php echo $display;?>"  rowspan="<?php echo $num ?> class="border">
            @if($detail[$i]['expense_project']['status'] == '0')
            Rejected
            @elseif($detail[$i]['expense_project']['status'] == '1')
            Draft
            @elseif($detail[$i]['expense_project']['status'] == '2')
            Waiting Verrification
            @elseif($detail[$i]['expense_project']['status'] == '3')
            Approved
            @endif 
        </td>
    </tr>

    <?php
    if ($detail[$i]['expense_project_id']==@$detail[$array]['expense_project_id']) {
        $display = 'none';
    }else
    {
        $display = '';
    }
 $no++;
 $array++;
 
 }
  ?>


@endif
</table>
<br>
<table cellpadding="7" class="border">
<caption style="text-align:left"><b>PROJECT NOTE</b><caption>
<tr class="border">
    <th class="border">Title</th>
    <th class="border">Note</th>
    <th class="border">Member</th>
</tr>
@if($note->count() == '0')
    <tr><td colspan="3" style="text-align:center;">There is no data to display </td></tr>
@else
@foreach($note as $data)
<tr class="border">
    <td class="border">{{ $data->note_title }}</td>
    <td class="border">{!! $data->note !!}</td>
    <td class="border">{{ $data->member->employee->employee_name }}</td>
</tr>
@endforeach
@endif
</table>
</body>
</html>
