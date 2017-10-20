//The program applies different sorting algorithms to a randomized
//array and compare its time of execution

//It uses dedicated class defined in the following files:
//ArraySorter.h
//ArrayClass.cpp

#include <iostream>
#include <ctime>
#include <unistd.h>
#include <stdlib.h>
#include "ArraySorter.h"
#include <iomanip>

using namespace std;


int main()
{

    clock_t start,stop;
    double executionTime;
    unsigned int numberOfElements;

    cout <<"Insert the number of elements in array to be sorted:" << endl;
    cin >> numberOfElements;
    int* arrayToBeSorted = new int[numberOfElements];

    //randomizing array
    srand(time(NULL));
    for(int i=0; i<numberOfElements; i++)
    {
        arrayToBeSorted[i] = rand()%numberOfElements+1;
    }
    //declaring backup array copy for unsort method
    int* arrayToBeSortedOriginal = new int[numberOfElements];
    copy ( arrayToBeSorted, arrayToBeSorted+numberOfElements, arrayToBeSortedOriginal );

    //setting high time precision
    setprecision(6);
    cout.setf(ios::fixed);

    //declaring the sorter and comparing all of its methods
    ArraySorter arraySorter(numberOfElements, arrayToBeSorted);
    cout << endl;
    cout <<"Sorting "<<numberOfElements <<" randomly generated numbers:"<<endl;
    cout <<endl;

    cout <<"--------------------------------------------------" << endl;
    cout<<"Insertion sort:"<<endl;
    cout <<"--------------------------------------------------" << endl;
    start = clock();
    arraySorter.insertion_sort();
    stop = clock();
    executionTime = (double)(stop-start) / CLOCKS_PER_SEC;
    cout << endl;
    cout <<"Sorting status: ";
    if(arraySorter.checkIfSorted()) cout <<"Sorted" << endl;
    else cout <<"Not sorted" << endl;
    cout<<endl<<"Execution time of Insertion sort:  "<<executionTime<<" s"<<endl;
    arraySorter.undoSort(arrayToBeSortedOriginal);
    cout << endl;

    cout <<"--------------------------------------------------" << endl;
    cout<<"Selection sort:"<<endl;
    cout <<"--------------------------------------------------" << endl;
    start = clock();
    arraySorter.selection_sort();
    stop = clock();
    executionTime = (double)(stop-start) / CLOCKS_PER_SEC;
    cout << endl;
    cout <<"Sorting status: ";
    if(arraySorter.checkIfSorted()) cout <<"Sorted" << endl;
    else cout <<"Not sorted" << endl;
    cout<<endl<<"Execution time of Selection sort:  "<<executionTime<<" s"<<endl;
    arraySorter.undoSort(arrayToBeSortedOriginal);
    cout << endl;

    cout <<"--------------------------------------------------" << endl;
    cout<<"Bubble Sort:"<<endl;
    cout <<"--------------------------------------------------" << endl;
    start = clock();
    arraySorter.bubbleSort();
    stop = clock();
    executionTime = (double)(stop-start) / CLOCKS_PER_SEC;
    cout << endl;
    cout <<"Sorting status: ";
    if(arraySorter.checkIfSorted()) cout <<"Sorted" << endl;
    else cout <<"Not sorted" << endl;
    cout<<endl<<"Execution time of Bubble Sort:  "<<executionTime<<" s"<<endl;
    cout << endl;
    arraySorter.undoSort(arrayToBeSortedOriginal);

    cout <<"--------------------------------------------------" << endl;
    cout<<"Merge Sort:"<<endl;
    cout <<"--------------------------------------------------" << endl;
    start = clock();
    arraySorter.mergeSort(0,numberOfElements-1 );
    stop = clock();
    executionTime = (double)(stop-start) / CLOCKS_PER_SEC;
    cout << endl;
    cout <<"Sorting status: ";
    if(arraySorter.checkIfSorted()) cout <<"Sorted" << endl;
    else cout <<"Not sorted" << endl;
    cout<<endl<<"Execution time of Merge Sort:  "<<executionTime<<" s"<<endl;
    cout << endl;
    arraySorter.undoSort(arrayToBeSortedOriginal);

    cout <<"--------------------------------------------------" << endl;
    cout<<"Quick Sort:"<<endl;
    cout <<"--------------------------------------------------" << endl;
    start = clock();
    arraySorter.quicksort(0,numberOfElements-1);
    stop = clock();
    executionTime = (double)(stop-start) / CLOCKS_PER_SEC;
    cout << endl;
    cout <<"Sorting status: ";
    if(arraySorter.checkIfSorted()) cout <<"Sorted" << endl;
    else cout <<"Not sorted" << endl;
    cout<<endl<<"Execution time of Quick Sort:  "<<executionTime<<" s"<<endl;
    cout << endl;
    arraySorter.undoSort(arrayToBeSortedOriginal);
    cout <<"--------------------------------------------------" << endl;

    //Release allocated memory
    delete[] arrayToBeSorted;
    delete[] arrayToBeSortedOriginal;

    return 0;
}


