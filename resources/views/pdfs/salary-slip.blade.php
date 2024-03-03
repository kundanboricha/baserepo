<!DOCTYPE html>
<html>

<head>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            margin: 5px;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .table,
        th,
        td {
            padding: 2px;
            border: 1px solid #000000;
        }

        td {
            padding: 0 5px;
        }

        .bold {
            font-weight: bold;
        }

        .p-0 {
            padding: 0 !important;
        }

        .p-1 {
            padding: 15px;
        }

        .no-border * {
            border: 0 !important;
        }

        .w-50 {
            width: 50%;
        }

        .img-holder {
            position: relative;
            padding: 10px;
        }

        .img {
            height: 50px;
            object-fit: cover;
        }

        .header {
            min-height: 150px;
        }

        .border-t-0 {
            border-top: none;
        }

        .border-b-0 {
            border-bottom: none;
        }

        .border-l-0 {
            border-left: none;
        }

        .border-r-0 {
            border-right: none;
        }

        .border-0 {
            border: none;
        }

        .mt-1 {
            margin-top: 1em;
        }
    </style>
</head>

<body>
    <table class="table">
        <tr>
            <td colspan="5" class="border-0">
                <table class="no-border header">
                    <tr>
                        <td class="img-holder">
                            <img src="{{ asset('custom_assets/images/pdf-logo.jpg') }}" class="img" alt="logo">
                        </td>
                        <td class="w-50 right">
                            <h3>CodersHut</h3>
                            Rajpath Club Road, Sindhubhavan Marg, Shilp Epitome<br>
                            Bodakdev, Ahmedabad, Gujarat 380054 <br> <br>

                            <b>Email:</b> info@codershut.in <br>
                            <b>Contact:</b> 9898469941 <br>
                            <b>Website:</b> https://codershut.in <br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="border-0">
                <div class="center bold p-1">
                    Salary Slip For The {{ $data['currentMonthYear'] }}
                </div>
            </td>
        </tr>
        <tr>
            <th colspan="5" class="center">Employee Details</th>
        </tr>

        <tr>
            <th width="25%">Employee Code:</th>
            <td width="25%">{{ $data['employee_code'] }}</td>

            <th width="25%">Bank Name:</th>
            <td width="25%" colspan="2">{{ $data['bank_name'] }}</td>
        </tr>

        <tr>
            <th>Employee Name:</th>
            <td>{{ $data['employee_name'] }}</td>

            <th>Bank Account Number:</th>
            <td colspan="2">{{ $data['bank_account_number'] }}</td>
        </tr>

        <tr>
            <th>Designation:</th>
            <td>{{ $data['designation'] }}</td>

            <th>PAN No:</th>
            <td colspan="2">{{ $data['pan_no'] }}</td>
        </tr>

        <tr>
            <th>Department:</th>
            <td>{{ $data['department'] }}</td>

            <th>UAN No:</th>
            <td colspan="2">{{ $data['uan_no'] }}</td>
        </tr>

        <tr>
            <th>Date of Joining:</th>
            <td>{{ $data['date_of_joining'] }}</td>

            <th>PF No:</th>
            <td colspan="2">{{ $data['pf_no'] }}</td>
        </tr>

        <tr>
            <th>Status:</th>
            <td>{{ $data['status'] }}</td>

            <th>ESIC No:</th>
            <td colspan="2">{{ $data['esic_no'] }}</td>
        </tr>

        <tr>
            <th colspan="5" class="p-1"></th>
        </tr>

        <tr>
            <th colspan="2" class="center">Leave Details</th>
            <th colspan="3" class="center">Attendence Details</th>
        </tr>

        <tr>
            <th>Leave Issued:</th>
            <td class="right">{{ $data['leave_issued'] }}</td>

            <th>Total Days:</th>
            <td colspan="2" class="right">{{ $data['total_day'] }}</td>
        </tr>
        <tr>
            <th>Leave Balance:</th>
            <td class="right">{{ $data['leave_balance'] }}</td>

            <th>Working Days:</th>
            <td colspan="2" class="right">{{ $data['working_day'] }}</td>
        </tr>
        <tr>
            <th>Leave taken:</th>
            <td class="right">{{ $data['leave_taken'] }}</td>

            <th>Present Day:</th>
            <td colspan="2" class="right">{{ $data['present_day'] }}</td>
        </tr>
        <tr>
            <th>El Encash No:</th>
            <td class="right">{{ $data['el_encash_no'] }}</td>

            <th>Leave Without Pay:</th>
            <td colspan="2" class="right">{{ $data['leave_without_pay'] }}</td>
        </tr>
        <tr>
            <th>Adjusted:</th>
            <td class="right">{{ $data['adjusted'] }}</td>

            <th></th>
            <td colspan="2" class="right"></td>
        </tr>
        <tr>
            <th>Balance C/F:</th>
            <td class="right">{{ $data['balance_cf'] }}</td>

            <th></th>
            <td colspan="2"></td>
        </tr>

        <tr>
            <th colspan="5" class="p-1"></th>
        </tr>

        <tr>
            <td colspan="5" class="p-0">
                <table style="border:0;">
                    <tr>
                        <th width="27.5%" class="border-t-0 border-l-0 ">Earning</th>
                        <th width="15%" class="border-t-0">CTC Amount</th>
                        <th width="15%" class="border-t-0">Salary Amt.</th>
                        <th width="27.5%" class="border-t-0">Deduction</th>
                        <th width="15%" class="border-t-0 border-r-0">Amount</th>
                    </tr>

                    <tr>
                        <td class="border-l-0">Basic Salary:</td>
                        <td class="right">{{ $data['ctc_basic_salary'] }}</td>
                        <td class="right">{{ $data['amt_basic_salary'] }}</td>

                        <td>Professional Tax:</td>
                        <td class="right border-r-0">{{ $data['professional_tax'] }}</td>
                    </tr>

                    <tr>
                        <td class="border-l-0">House Rent Allow:</td>
                        <td class="right">{{ $data['ctc_house_rent_allow'] }}</td>
                        <td class="right">{{ $data['amt_house_rent_allow'] }}</td>

                        <td>Income Tax:</td>
                        <td class="right border-r-0">{{ $data['income_tax'] }}</td>
                    </tr>

                    <tr>
                        <td class="border-l-0">Other Allownces:</td>
                        <td class="right">{{ $data['ctc_other_allownces'] }}</td>
                        <td class="right">{{ $data['amt_other_allownces'] }}</td>

                        <td>Gratuity:</td>
                        <td class="right border-r-0">{{ $data['gratuity'] }}</td>
                    </tr>

                    <tr>
                        <td class="border-l-0">Bonus:</td>
                        <td class="right">{{ $data['ctc_bonus'] }}</td>
                        <td class="right">{{ $data['amt_bonus'] }}</td>

                        <td>PF Employee Contribution:</td>
                        <td class="right border-r-0">{{ $data['pf_employee_contribution'] }}</td>
                    </tr>

                    <tr>
                        <td class="border-l-0">Other:</td>
                        <td class="right">{{ $data['ctc_other'] }}</td>
                        <td class="right">{{ $data['amt_other'] }}</td>

                        <td>ESI Employee Contribution:</td>
                        <td class="right border-r-0">{{ $data['esi_employee_contribution'] }}</td>
                    </tr>

                    <tr>
                        <td class="border-l-0">EL Encash Amount:</td>
                        <td class="right">{{ $data['ctc_el_encash_amount'] }}</td>
                        <td class="right">{{ $data['amt_el_encash_amount'] }}</td>

                        <td>Leave Without Pay:</td>
                        <td class="right border-r-0">{{ $data['leave_without_pay'] }}</td>
                    </tr>

                    <tr>
                        <th class="p-1 border-l-0"></th>
                        <th class="p-1"></th>
                        <th class="p-1"></th>
                        <th class="p-1"></th>
                        <th class="p-1 border-r-0"></th>
                    </tr>

                    <tr>
                        <th class="p-1 border-l-0"></th>
                        <th class="p-1"></th>
                        <th class="p-1"></th>
                        <td>Total Deduction:</td>
                        <td class="right border-r-0">{{ $data['total_deduction'] }}</td>
                    </tr>

                    <tr>
                        <th class="border-b-0 border-l-0">Total Earning:</th>
                        <td class="right border-b-0">{{ $data['ctc_total_earning'] }}</td>
                        <td class="right border-b-0">{{ $data['amt_total_earning'] }}</td>

                        <th class="border-b-0">Net Amount:</th>
                        <td class="right border-b-0 border-r-0">{{ $data['net_amount'] }}</td>
                    </tr>
                </table>
            </td colspan="2"d>
        </tr>

        <tr>
            <th colspan="5" class="center p-1">
                This Salary Slip is auto generated by computer which does not require signature.
            </th>
        </tr>
    </table>

</body>



</html>
