import 'dart:convert';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import '../model/msg_otp-model.dart';
import '../utils/config.dart';

class MsgOtpController extends GetxController implements GetxService {

  MsgOtpModel? msgOtpModel;

  Future msgOtpApi({required String mobile}) async{
    Map body = {
      "mobile": mobile
    };
    Map<String, String> userHeader = {"Content-type": "application/json", "Accept": "application/json"};
    var response = await http.post(Uri.parse(Config.baseUrl + Config.msgOtp),body: jsonEncode(body),headers: userHeader);

    print("+++++++ ${response.body}");
    print("----- ${body}");

    var data = jsonDecode(response.body);
    if(response.statusCode == 200){
      if(data["Result"] == "true"){
        msgOtpModel = msgOtpModelFromJson(response.body);
        if(msgOtpModel!.result == "true"){
          update();
          print("///////////////// ${data}");
          return data;
        }
        else{
          Fluttertoast.showToast(msg: msgOtpModel!.result.toString());
        }
      }
      else{
        Fluttertoast.showToast(msg: "${data["ResponseMsg"]}",);
      }
    }else{
      Fluttertoast.showToast(msg: "Please update the content from the backend panel. It appears that the correct data was not uploaded, or there may be issues with the data that was added.",);
    }
  }
}