<style>
    table.wrap-box {
        width: 100%;
        text-align: left;
        line-height: 97%;
    }

    table.wrap-top {
        width: 100%;        
        text-align: left;
        line-height: 97%;
    }

    table.wrap-content, table.wrap-total {
        width: 100%;        
        text-align: left;
        line-height: 97%;
    }
    table.wrap-content tr th{
        font-weight: bold;
        text-align: left;
        background-color: #eee;
    }

    table.wrap-content tr td{
        border-bottom-color: #ddd;
        border-bottom-style: solid;
        border-bottom-width: 0.5px;
    }

    table.wrap-total tr td{
        text-align: right;
    }

    .line-top{
        border-top: 1px solid #ccc;
    }
    .line-bottom{
        border-bottom: 1px solid #ccc;
    }
    .line-left{
        border-left: 1px solid #ccc;
    }
    .line-right{
        border-right: 1px solid #ccc;
    }

    .header-title {
        font-size: 22px;
        font-weight: bold;
    }    
</style>
<table class="wrap-box" cellpadding="0" cellspacing="0">
    <tr>        
        <td style="width: 60%;"><span class="header-title">&nbsp;</span>
        </td>
        <td style="text-align: right;width: 40%;"><span class="header-title">สิ่งอุปกรณ์</span></td>
    </tr>
</table>
<table class="wrap-box line-top" cellpadding="0" cellspacing="0">
    <tr>  
        <td><table class="wrap-top" cellpadding="3" cellspacing="0">
                <tr>
                    <td style="width:25%;"><b>รหัสผู้ยืม</b></td>
                    <td style="width:75%;"><?php echo $data['member_code']; ?></td>
                </tr>
                <tr>
                    <td style="width:25%;"><b>ผู้ยืม</b></td>
                    <td style="width:75%;"><?php echo $data['member_name']; ?></td>
                </tr>
                <tr>
                    <td style="width:25%;"><b>หน่วยงาน</b></td>
                    <td style="width:75%;"><?php echo $data['department_name']; ?></td>
                </tr>
            </table>
        </td>
        <td><table class="wrap-top" cellpadding="3" cellspacing="0">
                <tr>
                    <td style="width:25%;"><b>วันที่ยืม</b></td>
                    <td style="width:75%;"><?php echo str_date($data['borrow_date']); ?></td>
                </tr>
                <tr>
                    <td style="width:25%;"><b>กำหนดคืน</b></td>
                    <td style="width:75%;"><?php echo str_date($data['schedule_date']); ?></td>
                </tr>
                <tr>
                    <td style="width:25%;"><b>วันที่คืน</b></td>
                    <td style="width:75%;">..../..../........</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="line"></div>
<table class="wrap-box" cellpadding="0" cellspacing="0">
    <tr>
        <td><table class="wrap-content" cellpadding="3" cellspacing="0">
            <tr>
                <th style="width:5%;">#</th>
                <th style="width:23%;"><?php echo line('prd_code'); ?></th>
                <th style="width:32%;"><?php echo line('prd_name'); ?></th>
                <th style="width:20%;"><?php echo line('prd_serial_number'); ?></th>
                <th style="width:10%;"><?php echo line('bod_borrow_quantity'); ?></th>
                <th style="width:10%;"><?php echo line('bod_return_quantity'); ?></th>
            </tr>
            <?php foreach($details as $key => $detail): ?>
                <tr>
                    <td style="text-align:center;"><?php echo ($key+1); ?></td>
                    <td><?php echo $detail['code']; ?></td>
                    <td><?php echo $detail['name']; ?></td>
                    <td><?php echo $detail['serial_code']; ?></td>
                    <td><?php echo number_format($detail['borrow_quantity'],2); ?></td>
                    <td>...................</td>
                </tr>
            <?php endforeach; ?>
        </table></td>
    </tr>
</table>
<table class="wrap-box" cellpadding="20" cellspacing="0">
    <tr>
        <td style="text-align:right;">....................................... ผู้ยืม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        ....................................... ผู้คืน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        ....................................... เจ้าหน้าที่<br/><br/>
        วันที่..........................
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        วันที่..........................
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        วันที่..........................
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
</table>