package com.example.wemped.virtualtourskeleton;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

/**
 * Created by wemped on 5/7/15.
 */

/*Fragment that each floor tab will contain*/

public class TabFragment extends Fragment{

    @Override
    public void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
    }

    public View onCreateView(LayoutInflater inflater,ViewGroup container,Bundle savedInstanceState){
        View v = inflater.inflate(R.layout.fragment_tab,container,false);

        //May need an adapter for number stops -> buttons here
        //Probably a ListView type adapter thing.
        //Should be reasonably straight forward following tutorials

        /*Example of how to get data
            can delete later*/
        TextView fake = (TextView) v.findViewById(R.id.fakeTExtView);

        fake.setText(getArguments().getString("TAB_ITEM_NAME"));

        return v;
    }
}
