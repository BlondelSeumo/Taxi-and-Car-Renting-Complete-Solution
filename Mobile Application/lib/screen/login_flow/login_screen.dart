// ignore_for_file: prefer_const_literals_to_create_immutables, prefer_const_constructors, empty_catches
import 'dart:convert';
import 'package:carlink/model/login_modal.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart' as http;
import 'package:carlink/controller/login_controller.dart';
import 'package:carlink/screen/bottombar/bottombar_screen.dart';
import 'package:carlink/screen/login_flow/resetpassword_screen.dart';
import 'package:carlink/screen/login_flow/signup_screen.dart';
import 'package:carlink/utils/Colors.dart';
import 'package:carlink/utils/Custom_widget.dart';
import 'package:carlink/utils/Dark_lightmode.dart';
import 'package:carlink/utils/fontfameli_model.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:intl_phone_field/intl_phone_field.dart';
import 'package:onesignal_flutter/onesignal_flutter.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../../utils/App_content.dart';
import '../../utils/config.dart';
import '../bottombar/carinfo_screeen.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  LoginController loginController = Get.find();
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();

  late ColorNotifire notifire;
  getdarkmodepreviousstate() async {
    final prefs = await SharedPreferences.getInstance();
    bool? previusstate = prefs.getBool("setIsDark");
    if (previusstate == null) {
      notifire.setIsDark = false;
    } else {
      notifire.setIsDark = previusstate;
    }
  }

  resetNew() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    prefs.setBool('isLogin', true);
    prefs.setBool('bottomsheet', true);
  }

  @override
  void initState() {
    getdarkmodepreviousstate();
    super.initState();
  }
  TextEditingController mobileController = TextEditingController();
  TextEditingController passwordController = TextEditingController();
  String ccode = "";

  LoginData? loginData;
  Future login(mobile,ccode, password) async {
    Map body = {
      'mobile' : mobile,
      'ccode' : ccode,
      'password' : password,
    };
    try{
      var response = await http.post(Uri.parse(Config.baseUrl+Config.login), body: jsonEncode(body), headers: {
        'Content-Type': 'application/json',
      });
      SharedPreferences prefs = await SharedPreferences.getInstance();
      var data = jsonDecode(response.body.toString());

      if(response.statusCode == 200){
        if(data["Result"] == "true"){
          prefs.setString('Usertype', data["type"]);
          data["type"] == "USER" ?  prefs.setString('UserLogin', jsonEncode(data["UserLogin"])) : prefs.setString('AdminLogin', jsonEncode(data["AdminLogin"]));
          setState(() {
            data["type"] == "USER" ? loginData = loginDataFromJson(response.body) : null;
          });
          return data;
        }else{
          return data;
        }
      } else {
        return data;
      }
    } catch(e){}
  }

  @override
  Widget build(BuildContext context) {
    notifire = Provider.of<ColorNotifire>(context, listen: true);
    return Scaffold(
      resizeToAvoidBottomInset: false,
      backgroundColor: notifire.getbgcolor,
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 15),
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                SizedBox(height: 10),
                InkWell(
                  onTap: () {
                    Get.back();
                  },
                  child: Container(
                    height: 40,
                    width: 40,
                    alignment: Alignment.center,
                    padding: EdgeInsets.all(6),
                    child: Image.asset(Appcontent.close, color: notifire.getwhiteblackcolor),
                  ),
                ),
                SizedBox(height: Get.size.height * 0.03),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text("Sign in to carlink".tr, style: TextStyle(fontFamily: FontFamily.europaBold, color: notifire.getwhiteblackcolor, fontSize: 28,),), SizedBox(height: 8,),
                      Text("Welcome back! Please enter your details.".tr, style: TextStyle(fontFamily: FontFamily.europaWoff, fontSize: 15, color: greyScale,),),
                      SizedBox(height: Get.size.height * 0.04),
                      IntlPhoneField(
                        controller: mobileController,
                        decoration:  InputDecoration(
                          counterText: "",
                          filled: true,
                          fillColor: notifire.getblackwhitecolor,
                          enabledBorder: OutlineInputBorder(
                              borderSide: BorderSide.none,
                              borderRadius: BorderRadius.circular(15)
                          ),
                          hintText: 'Phone Number'.tr,
                          hintStyle: TextStyle(color: greyColor, fontSize: 14, fontFamily: FontFamily.europaWoff),
                          border: OutlineInputBorder(
                            borderSide: BorderSide.none,
                            borderRadius: BorderRadius.circular(15),
                          ),
                          focusedErrorBorder: OutlineInputBorder(
                            borderSide: BorderSide(color: onbordingBlue),
                            borderRadius: BorderRadius.circular(15),
                          ),
                          focusedBorder: OutlineInputBorder(
                            borderSide: BorderSide(color: onbordingBlue),
                            borderRadius: BorderRadius.circular(15),
                          ),
                        ),
                        style: TextStyle(color: notifire.getwhiteblackcolor, fontFamily: FontFamily.europaBold),
                        flagsButtonPadding: EdgeInsets.only(left: 7),
                        dropdownTextStyle: TextStyle(color: notifire.getwhiteblackcolor),
                        showCountryFlag: false,
                        dropdownIcon: Icon(Icons.phone_outlined, color: greyScale),
                        initialCountryCode: 'IN',
                        onCountryChanged: (value) {
                          setState(() {
                            ccode = value.dialCode;
                          });
                        },
                        onChanged: (number) {
                          setState(() {
                            ccode = number.countryCode;
                          });
                        },
                      ),
                      SizedBox(height: 15),
                      GetBuilder<LoginController>(builder: (context) {
                        return textFormFild(
                          notifire,
                          controller: passwordController,
                          obscureText: loginController.showPassword,
                          suffixIcon: InkWell(
                            onTap: () {
                              loginController.showOfPassword();
                            },
                            child: !loginController.showPassword
                                ? Padding(
                              padding: const EdgeInsets.all(10),
                              child: Image.asset("assets/eye.png", height: 25, width: 25, color: greyColor),
                            )
                                : Padding(
                              padding: const EdgeInsets.all(10),
                              child: Image.asset("assets/eye-off.png", height: 25, width: 25, color: greyColor),
                            ),
                          ),
                          prefixIcon: Padding(
                            padding: const EdgeInsets.all(10),
                            child: Image.asset("assets/lock.png", height: 25, width: 25, color: greyColor),
                          ),
                          labelText: "Password".tr,
                          validator: (value) {
                            if (value == null || value.isEmpty) {
                              return 'Please enter your password'.tr;
                            }
                            return null;
                          },
                        );
                      }),
                      SizedBox(height: 10),
                      InkWell(
                        onTap: () {
                          Get.to(ResetPasswordScreen());
                        },
                        child: RichText(
                          text: TextSpan(
                            children: [
                              TextSpan(text: 'Forgot password? '.tr, style: TextStyle(fontFamily: FontFamily.europaWoff, color: notifire.getwhiteblackcolor, fontSize: 15)),
                              TextSpan(text: 'Reset it'.tr, style: TextStyle(fontFamily: FontFamily.europaBold, color: onbordingBlue, fontSize: 15)),
                            ],
                          ),
                        ),
                      ),
                      SizedBox(height: Get.size.height * 0.03),
                      GestButton(
                        height: 50,
                        Width: Get.size.width,
                        margin: EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                        buttoncolor: onbordingBlue,
                        buttontext: "Sign In".tr,
                        style: TextStyle(color: WhiteColor, fontFamily: FontFamily.europaBold, fontSize: 15),
                        onclick: () {
                          if(mobileController.text.isNotEmpty && passwordController.text.isNotEmpty){
                            if (_formKey.currentState?.validate() ?? false) {
                              login(mobileController.text, ccode, passwordController.text).then((value) async {
                                if(value["ResponseCode"] == "200"){
                                  Fluttertoast.showToast(msg: value['ResponseMsg']);

                                  resetNew();
                                  SharedPreferences pref = await SharedPreferences.getInstance();
                                  String user =  pref.getString("Usertype")!;

                                  if(user == "ADMIN"){
                                    OneSignal.User.addTagWithKey("user_id",'0');
                                    Get.offAll(CarInfoScreen());
                                  }else{
                                    OneSignal.User.addTagWithKey("user_id", loginData?.userLogin.id);
                                    Get.offAll(BottomBarScreen());
                                  }

                                } else {
                                  Fluttertoast.showToast(msg: value['ResponseMsg']);
                                }
                              });
                            }
                          }else {
                            Fluttertoast.showToast(msg: 'Please some your text');
                          }

                        },
                      ),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Text("Don’t have and account?".tr, style: TextStyle(fontFamily: FontFamily.europaWoff, color: notifire.getwhiteblackcolor, fontSize: 15)),
                          TextButton(
                            onPressed: () {
                              Get.to(SignUpScreen());
                            },
                            child: Text("Sign Up".tr, style: TextStyle(fontFamily: FontFamily.europaBold, color: onbordingBlue, fontSize: 15)),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
