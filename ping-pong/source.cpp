//---------------------------------------------------------------------------

#include <vcl.h>
#pragma hdrstop

#include "Unit1.h"
//---------------------------------------------------------------------------
#pragma package(smart_init)
#pragma resource "*.dfm"
#include <fstream>
#include <mmsystem.h>

using namespace std;
TForm1 *Form1;

int x = -5;
int y = -5;
int playerLeftPoints = 0;
int playerRightPoints = 0;
int nOfBounces = 0;
int yPaddlePosition = 12;
int record;

AnsiString playerLeft, playerRight;

//---------------------------------------------------------------------------
__fastcall TForm1::TForm1(TComponent* Owner)
        : TForm(Owner)
{
}
//---------------------------------------------------------------------------

// timer handling downward motion of the left paddle
void __fastcall TForm1::TimerPaddleLeftDown(TObject *Sender)
{
      if(paddleLeft->Top + paddleLeft->Height < ceiling -> Height - 10) paddleLeft->Top +=  yPaddlePosition;
}

// timer handling upward motion of the left paddle
void __fastcall TForm1::TimerPaddleLeftUp(TObject *Sender)
{
       if(paddleLeft->Top > 7) paddleLeft->Top -=  yPaddlePosition;
}
// timer handling upward motion of the right paddle

void __fastcall TForm1::TimerPaddleRightUp(TObject *Sender)
{
        if(paddleRight ->Top > 7)paddleRight->Top -=  yPaddlePosition;
}
// timer handling downward motion of the right paddle

void __fastcall TForm1::TimerPaddleRightDown(TObject *Sender)
{
       if(paddleRight->Top + paddleRight->Height < ceiling -> Height - 10 ) paddleRight->Top +=  yPaddlePosition;
}

// enabling proper timer while pressing the corresponing button
void __fastcall TForm1::FormKeyDown(TObject *Sender, WORD &Key,
      TShiftState Shift)
{
       if(Key == 'A' || Key == 'a') TimerPaddleLeftUp->Enabled = true;
       if(Key == 'Z' || Key == 'z') TimerPaddleLeftDown->Enabled = true;
       if(Key == VK_UP) TimerPaddleRightUp->Enabled = true;
       if(Key == VK_DOWN) TimerPaddleRightDown->Enabled = true;
}

// disabling proper timer while releasing the corresponing button
void __fastcall TForm1::FormKeyUp(TObject *Sender, WORD &Key,
      TShiftState Shift)
{
       if(Key == 'A' || Key == 'a') TimerPaddleLeftUp->Enabled = false;
       if(Key == 'Z' || Key == 'z') TimerPaddleLeftDown->Enabled = false;
       if(Key == VK_UP) TimerPaddleRightUp->Enabled = false;
       if(Key == VK_DOWN) TimerPaddleRightDown->Enabled = false;
}
//---------------------------------------------------------------------------
// Ball behaviour part
//---------------------------------------------------------------------------
void __fastcall TForm1::TimerBall(TObject *Sender)
{
       AnsiString nOfBouncesString = IntToStr(nOfBounces);
	   
	   //change of the ball's coordinates sec by sec
       ball->Left+=x;
       ball->Top+=y;

	   //change of the difficulty level depending on number of bounces
        if((nOfBounces  == 10))
        {
			x = 10;
	    }
        else if( nOfBounces == 20)
       {
			x = 12;

            paddleLeft->Picture->LoadFromFile("img/paddle_2.bmp");
            paddleRight->Picture->LoadFromFile("img/paddle_2.bmp");
        }
        else if ( nOfBounces == 30)
        {
			x = 15;
			paddleLeft->Picture->LoadFromFile("img/paddle_3.bmp");
			paddleRight->Picture->LoadFromFile("img/paddle_3.bmp");
        }
        else if ( nOfBounces == 40)
        {
         x = 17;
        }
        //bounce from the ceiling
        if(ball->Top <= ceiling->Top) y = -y;
		
        //boune from the floor
        if(ball->Top + ball->Height >=  ceiling->Height) y = -y;

        //fail of the player 1
        if(ball->Left  <= paddleLeft->Left - 15)
        {
             TimerBall->Enabled=false;
             ball->Visible = false;
             playerRightPoints++;
             playerLeft = IntToStr(playerLeftPoints);
             playerRight = IntToStr(playerRightPoints);
             Button1->Visible = true;
             Button2->Visible = true;
             Button4->Caption = "Kasuj najlepsze wyniki";
             Button4->Visible = true;
             Label1->Caption = "Punkt dla gracza prawego >";
             Label1->Visible = true;
             Label2->Caption = playerLeft+":"+playerRight;
             Label2->Visible = true;
             Label3->Caption = "liczba odbiæ:  " + nOfBouncesString;
             Label3->Visible = true;
    
             fstream plik;
             plik.open("rekord.dat", ios::binary | ios::in);
             if(!plik)
             {
              ShowMessage("B³¹d otwarcia pliku z rekordami. Upewnij siê, ¿e plik rekord.dat znajduje siê w folderze z programem");
               Application->Terminate();

             }
             plik.seekg(0, ios::beg);
             if(! plik.read( reinterpret_cast<char*>( &record), sizeof(record)))
             {

                Application->Terminate();

             }
             plik.close();
             plik.open("rekord.dat", ios::binary | ios::out | ios::in);
             if(!plik)
             {

              Application->Terminate();

             }
			 // save best record in a binary file
             if(nOfBounces > record)
             {
               Label4->Caption = "GRATULACJE! NOWY REKORD LICZBY ODBIC!";
               Label4->Visible = true;
               if(!plik.write(reinterpret_cast<char*>(&nOfBounces), sizeof(nOfBounces)))
               {
                     Application->Terminate();
               }

             }
             plik.close();

        }
             //fail of the player 2
        else if(ball->Left >= paddleRight->Left + 15)
        {
             TimerBall->Enabled=false;
             ball->Visible = false;
             playerLeftPoints++;
             playerLeft = IntToStr(playerLeftPoints);
             playerRight = IntToStr(playerRightPoints);
             Button1->Visible = true;
             Button2->Visible = true;
             Button4->Caption = "Kasuj najlepsze wyniki";
             Button4->Visible = true;
             Label1->Caption = "< Punkt dla gracza lewego";
             Label1->Visible = true;
             Label2->Caption = playerLeft+":"+playerRight;
             Label2->Visible = true;
             Label3->Caption = "liczba odbiæ:  " + nOfBouncesString;
             Label3->Visible = true;
             fstream plik;
             plik.open("rekord.dat", ios::binary | ios::in);
              if(!plik)
             {
              ShowMessage("B³¹d otwarcia pliku z rekordami. Upewnij siê, ¿e plik rekord.dat znajduje siê w folderze z programem");
               Application->Terminate();

             }
             plik.seekg(0, ios::beg);
             if(! plik.read( reinterpret_cast<char*>( &record), sizeof(record)))
             {
                Application->Terminate();

             }
             plik.close();
             plik.open("rekord.dat", ios::binary | ios::out | ios::in);
             if(!plik)
             {

              Application->Terminate();

             }
             if(nOfBounces > record)
             {
               Label4->Caption = "GRATULACJE! NOWY REKORD LICZBY ODBIC!";
               Label4->Visible = true;
               if(!plik.write(reinterpret_cast<char*>(&nOfBounces), sizeof(nOfBounces)))
               {
                     Application->Terminate();
               }
             }
             plik.close();
        }
		// Bounce from the left paddle 
        else if(((ball->Left < paddleLeft->Left + paddleLeft->Width) &&
        (ball->Top + ball->Height > paddleLeft->Top ) && (ball->Top  < paddleLeft->Top + paddleLeft->Height)))
        {
			  if(x<0) // to proctect the ball from wobbling 
			  {
				x = -x;      
				nOfBounces++;
				nOfBouncesString = IntToStr(nOfBounces);
				sndPlaySound("snd/d1.wav",SND_ASYNC);
			  }
        }
		// Bounce from the right paddle 
        else if (((ball->Top + ball>Height > paddleRight->Top ) && (ball->Top  < paddleRight->Top + paddleRight->Height) && (ball->Left + ball->Width > paddleRight->Left ))  )
        {

              if( x >0)// to proctect the ball from wobbling 
              {
                 x = -x;
                 nOfBounces++;
                 nOfBouncesString = IntToStr(nOfBounces);
                 sndPlaySound("snd/d2.wav",SND_ASYNC);
              }
        }

}
//---------------------------------------------------------------------------

//---------------------------------------------------------------------------
void __fastcall TForm1::Button3Click(TObject *Sender)
{
		//start first game
        b->Left = 440;
        b-> Top = 176;
        playerLeftPoints = 0;
        playerRightPoints = 0;
        nOfBounces = 0;
        b->Visible = true;
        x = -8;
        y =-8;
        timer_b ->Enabled = true;
        Button1->Visible = false;
        Button2->Visible = false;
        Label1->Visible = false;
        Label2->Visible = false;
        Label3->Visible = false;
        Button3->Visible = false;
}
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
void __fastcall TForm1::Button1Click(TObject *Sender)
{
	 //new game (during the play)
     if(Application->MessageBox("Czy na pewno chcesz zaczac od nowa?","PotwierdŸ", MB_YESNO | MB_ICONQUESTION) == IDYES )
    {
        ball->Left = 440;
        ball-> Top = 176;
        playerLeftPoints = 0;
        playerRightPoints = 0;
        nOfBounces = 0;
        ball->Visible = true;
        x = -8;
        y =-8;
        TimerBall ->Enabled = true;
        Button1->Visible = false;
        Button2->Visible = false;
        Button4->Visible = false;
        Label1->Visible = false;
        Label2->Visible = false;
        Label3->Visible = false;
        Label4->Visible = false;
        paddleLeft->Picture->LoadFromFile("img/paddle.bmp");
        paddleRight->Picture->LoadFromFile("img/paddle.bmp");
    }

}
//---------------------------------------------------------------------------

void __fastcall TForm1::Button2Click(TObject *Sender)
{
		//next round
        b->Left = 440;
        b-> Top = 176;
        nOfBounces = 0;
        b->Visible = true;
        x = -8;
        y = -8;
        timer_b ->Enabled = true;
        Button1->Visible = false;
        Button2->Visible = false;
        Button4->Visible = false;
        Label1->Visible = false;
        Label2->Visible = false;
        Label3->Visible = false;
        Label4->Visible = false;
        paddleLeft->Picture->LoadFromFile("img/paddle.bmp");
        paddleRight->Picture->LoadFromFile("img/paddle.bmp");

}
//---------------------------------------------------------------------------

void __fastcall TForm1::FormCreate(TObject *Sender)
{
ShowMessage(
    "Witaj w grze ping-pong! \n\nLewy gracz steruje klawiszem 'A' - do góry, 'Z' - na dó³.\nPrawy gracz steruje klawiszami strza³ek góra-dó³.\nCo parê odbic pi³ki poziom trudnosci gry ulega zwiêkszeniu.\nW przypadku pobicia rekordu liczby odbic, program wyswietla odpowiednia informacje na ekranie. \n\nMi³ej zabawy!"
    );

          Button3->Visible = true;
          b->Visible = true;
          timer_b ->Enabled = false;
          b->Left = 440;
          b-> Top = 176;
          playerLeftPoints = 0;
          playerRightPoints = 0;
          x = -8;
          y = -8;
}
//---------------------------------------------------------------------------

void __fastcall TForm1::FormClose(TObject *Sender, TCloseAction &Action)
{
         if(Application->MessageBox("Czy na pewno chcesz zakoñczyæ ?","PotwierdŸ", MB_YESNO | MB_ICONQUESTION) == IDNO )
		{
        Action=caNone;
		}
}


//delete best results
void __fastcall TForm1::Button4Click(TObject *Sender)
{
       if(Application->MessageBox(
    "Czy na pewno chcesz skasowac najlepsze wyniki?","PotwierdŸ",
    MB_YESNO | MB_ICONQUESTION) == IDYES )
    {

      int kas = 0;
      fstream plik;
      plik.open("rekord.dat", ios::binary | ios::out | ios::in | ios::trunc);

      if(!plik)
             {
              ShowMessage("B³¹d otwarcia pliku z rekordami. Upewnij siê, ¿e plik rekord.dat znajduje siê w folderze z programem");
               Application->Terminate();

             }

      plik.write(reinterpret_cast<char*>(&kas), sizeof(kas));
      plik.close();
      Button4->Caption = "Skasowano!";
      }
}
//---------------------------------------------------------------------------

