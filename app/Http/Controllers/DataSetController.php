<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataSetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DataSetController extends Controller
{
    public function index()
    {
        $search = (isset($_GET['search'])? $_GET['search']: '');

        if ($search != '' && isset($search))
        {
            $users = User::where('category', 'LIKE', '%' . $search . '%')
                ->orWhere('firstname', 'LIKE', '%' . $search . '%')
                ->orWhere('lastname', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('gender', 'LIKE', '%' . $search . '%')
                ->orWhere('birthday', 'LIKE', '%' . $search . '%')
                ->orderBy('id','desc')->simplePaginate(100);

        } elseif (isset($_GET['start_date']) && isset($_GET['end_date'])) {
            //dogum tarixine gore axtaris
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $users = User::where('birthday', '>=', $start_date)
                ->where('birthday', '<=', $end_date)
                ->orderBy('id', 'desc')
                ->simplePaginate(100);

        }else {
            $users = User::orderBy('id','desc')->simplePaginate(100);
        }

        return view('dashboard.index',compact('users'));
    }

    public function export()
    {
        try {

            $connect = DB::connection()->getPdo();
            $get_all_table_query = "SHOW TABLES";
            $statement = $connect->prepare($get_all_table_query);
            $statement->execute();

            $output = '';
            $table = "users";
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();
            foreach($show_table_result as $show_table_row)
            {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();
            for($count=0; $count<$total_row; $count++)
            {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
            }

            $file_name = 'database_backup_on_' . date('y-m-d') . '.csv';
            $file_handle = fopen($file_name, 'w+');
            fwrite($file_handle, $output);
            fclose($file_handle);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_name));
            ob_clean();
            flush();
            readfile($file_name);
            unlink($file_name);

            DB::commit();
            return redirect()->back()->with('messages', 'Məlumat yükləndi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }

    public function store(DataSetRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if($validator->fails()) {
            return redirect()->back()->with('errors', $validator->messages());
        }

        try {
            $file = $request->file('file');
            /* txt faylar */
            $txt = file($file,FILE_IGNORE_NEW_LINES);
            foreach ($txt as $i => $line) {
                //Fayldakı datalar

                if ($i != 0)
                {
                    $data = explode(',', $line);
                    $birthday = strtotime($data[5]);

                    $user = new User();
                    $user->category = $data[0];
                    $user->firstname = $data[1];
                    $user->lastname = $data[2];
                    $user->email = $data[3];
                    $user->gender = $data[4];
                    $user->birthday = date('Y-m-d',$birthday);
                    $user->save();
                }
            }

            /*
            csv file olardısa
            $csv = fopen($file, 'r');
            $file = (isset($csv)? $csv: $txt);

            while (($data = fgetcsv($txt)) !== false) {
                print_r($data);
            }
            fclose($file);
            */

            DB::commit();
            return redirect()->back()->with('messages', 'Melumat əlavə edildi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }
}
