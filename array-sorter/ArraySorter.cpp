#include <iostream>
#include <ctime>
#include <unistd.h>
#include <stdlib.h>
#include "ArraySorter.h"

using namespace std;


ArraySorter::ArraySorter(int n, int t[]): numberOfElements(n), tab(t){}
ArraySorter::~ArraySorter()
{
 cout <<"Removing ArraySorter object" << endl;
}
//taken from http://www.algorytm.org/
void ArraySorter::insertion_sort()
{
    int temp, j;
    for( int i = 1; i < numberOfElements; i++ )
    {
        temp = tab[ i ];
        for( j = i - 1; j >= 0 && tab[ j ] > temp; j-- )
        {
            tab[ j + 1 ] = tab[ j ];
        }
        tab[ j + 1 ] = temp;
    }
}
//taken from http://www.algorytm.org/
void ArraySorter::selection_sort()
{
    int j, k;
    for(int i=0; i<numberOfElements; i++)
    {
        k=i;
        for(j=i+1; j<numberOfElements; j++)
        {
            if(tab[j]<tab[k]) k=j;
        }
        swap(tab[k], tab[i]);
    }
}
//taken from http://www.algorytm.org/
void ArraySorter::bubbleSort()
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
//taken from http://www.algorytm.org/
//----------------------------------------------
void ArraySorter::quicksort(int left, int right)
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
//----------------------------------------------

//taken from http://www.algorytm.org/
void ArraySorter::fusion(int start, int middle, int last) //auxiliary function of merge-sort algorithm
{
    int *tab_pom = new int[(last-start+1)]; // creation of auxiliary array
    int i = start, j = middle+1, k = 0; // auxiliary variables
    while (i <= middle && j <= last)
    {
        if (tab[j] < tab[i])
        {
            tab_pom[k] = tab[j];
            j++;
        }
        else
        {
            tab_pom[k] = tab[i];
            i++;
        }
        k++;
    }
    if (i <= middle)
    {
        while (i <= middle)
        {
            tab_pom[k] = tab[i];
            i++;
            k++;
        }
    }
    else
    {
        while (j <= last)
        {
            tab_pom[k] = tab[j];
            j++;
            k++;
        }
    }
    for (i = 0; i <= last-start; i++)
        tab[start+i] = tab_pom[i];

    delete [] tab_pom;
}
void ArraySorter::mergeSort(int start, int last)
{
    int middle;
    if (start != last)
    {
        middle = (start + last)/2;
        mergeSort(start, middle);
        mergeSort(middle+1, last);
        fusion(start, middle, last);
    }
}
//----------------------------------------------

bool ArraySorter::checkIfSorted()
{
    bool sorted = true;
    for(int i=0; i<numberOfElements-1; i++)
    {
        if(tab[i]>tab[i+1]) sorted = false;

    }
    return sorted;

}
void ArraySorter::displayArray()
{
    for(int i = 0; i < numberOfElements; i ++)
    {
        cout << tab[i] <<" ";
    }
    cout << endl;
}

void ArraySorter::undoSort(int tab2[])
{
    copy ( tab2, tab2+numberOfElements, tab );
}

