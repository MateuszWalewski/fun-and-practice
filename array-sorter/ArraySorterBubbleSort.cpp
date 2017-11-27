#include <iostream>
#include "ArraySorterBubbleSort.h"

using namespace std;


ArraySorterBubbleSort::ArraySorterBubbleSort(int n, int t[]):numberOfElements(n),tab(t) {}
ArraySorterBubbleSort::~ArraySorterBubbleSort()
{

}

//taken from http://www.algorytm.org/
void ArraySorterBubbleSort::launch()
{
     for(int i=1; i<numberOfElements; i++)
    {
        for(int j=numberOfElements-1; j>=1; j--)
        {
            if(tab[j]<tab[j-1])
            {
                int bufor;
                bufor=tab[j-1];
                tab[j-1]=tab[j];
                tab[j]=bufor;
            }
        }
    }
}

