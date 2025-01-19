import 'dart:convert';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import '../model/sms_type_model.dart';
import '../utils/config.dart';

class SmsTypeController extends GetxController implements GetxService {

  SmsTypeModel? smsTypeModel;
  Future smsTypeApi() async {
    Map<String,String> userHeader = {"Content-type": "application/json", "Accept": "application/json"};
    var response = await http.get(Uri.parse(Config.baseUrl + Config.smsType),headers: userHeader);

    print("++++++++++++++++ ${response.body}");

    var data = jsonDecode(response.body);
    if(response.statusCode == 200){
      if(data["Result"] == "true"){
        smsTypeModel = smsTypeModelFromJson(response.body);
        if(smsTypeModel!.result == "true"){
          update();
          // print("***************** ${data}");
          return data;
        }else{
          // Fluttertoast.showToast(msg: "${data["message"]}");
        }
      }
      else{
        // Fluttertoast.showToast(msg: "${data["message"]}");
      }
    }
    else{
      Fluttertoast.showToast(msg: "Please update the content from the backend panel. It appears that the correct data was not uploaded, or there may be issues with the data that was added.");
      // ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("Please update the content from the backend panel. It appears that the correct data was not uploaded, or there may be issues with the data that was added.")));
    }
  }
}