#include <iostream>
#include "ArraySorterQuickSort.h"

using namespace std;


ArraySorterQuickSort::ArraySorterQuickSort(int n, int t[]):numberOfElements(n),tab(t) {}
ArraySorterQuickSort::~ArraySorterQuickSort()
{

}


void ArraySorterQuickSort::launch()
{
    int left = 0;
    int right = numberOfElements-1;
    quicksort(left, right);
}

//taken from http://www.algorytm.org/

void ArraySorterQuickSort::quicksort(int left, int right)
{
    int v=tab[(left+right)/2];
    int i,j,x;
    i=left;
    j=right;
    do
    {
        while(tab[i]<v) i++;
        while(tab[j]>v) j--;
        if(i<=j)
        {
            x=tab[i];
            tab[i]=tab[j];
            tab[j]=x;
            i++;
            j--;

        }
    }
    while(i<=j);
    if(j>left) quicksort(left, j);
    if(i<right) quicksort( i, right);
}



